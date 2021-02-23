<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'date_of_birth' => ['required', 'date'],
            'byProvider'=>['boolean'],
        ]);

        $validator->after(function($validator){
          if (!$dateOfBirth = \strtotime(request('date_of_birth')))
            return; //already hit required rule
          
          $cutOffDate = \strtotime('-18 years');
          if ($dateOfBirth > $cutOffDate){
            $validator->errors()->add('date_of_birth', __('You must be at least 18 years old to register'));
            return;
          }

          //Check email is in email.json if this is not a provider
          $byProvider = $validator->getData()['byProvider'] ?? false;
          if (!$byProvider){
            $email = trim(strtolower(request('email')));
            if (!$emails = \json_decode(file_get_contents(public_path().'/email.json')))
              $validator->errors()->add('email', __('Failed to load list of valid emails'));
            if (!in_array($email, $emails))
              $validator->errors()->add('email', __('This email has not completed the affirmation process'));
          }
          
        });

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/

        // dd($data);
        $dob = $data['date_of_birth'] ?? '';
        if (!empty($dob)) {

            $data['date_of_birth'] = date("Y-m-d", strtotime($dob));

        }
      
        $patientProfile = new \App\PatientProfile();

        $user = config('roles.models.defaultUser')::create([
            'name' => $data['first_name']." ".$data['last_name'],
            'email' => $data['email'],
            'json' => json_encode($data),
            'dob' => $data['date_of_birth'] ?? '',
            'password' => bcrypt($data['password']),
            'burstiq_private_id' => $patientProfile->newPrivateId(),
        ]);

        //Remove passwords
        unset($data['password']);
        unset($data['password_confirmation']);

        // backup spool
        file_put_contents('/var/www/data/' . $data['email'], json_encode($data));

        if($data['r_type']) {
          $role = config('roles.models.role')::where('slug', '=', $data['r_type'])->first();  //choose the default role upon user creation.
          if($role)
            $user->attachRole($role);

          //for BurstIq
          if($data['r_type'] == "patient") {
            //Call for inserting Patient Record in BurstIq

          }

          if($data['r_type'] == "provider") {
            //Call for inserting Provider Record in BurstIq

          }

        }

        return $user;
    }

    /**
     * Handles the registration of a patient by a provider
     * @return user instance of newly create user record
     */
    function RegisterPatient(array $data){
      $data['byProvider'] = true;
      $data['r_type'] = "patient";
      $validator = $this->validator($data);
      $validator->validate();
      return $this->create($data);
    }
}
