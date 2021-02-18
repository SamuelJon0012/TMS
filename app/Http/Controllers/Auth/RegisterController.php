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
        ]);

        $validator->after(function($validator){
          $dateOfBirth = request('date_of_birth');
          if (empty($dateOfBirth))
            return; // Accept blank dates

          if (!$dateOfBirth = \strtotime($dateOfBirth)){
            $validator->errors()->add('date_of_birth', 'Invalid Date of Birth');
            return;
          }
          
          $cutOffDate = \strtotime('-18 years');
          if ($dateOfBirth > $cutOffDate){
            $validator->errors()->add('date_of_birth', 'You must be at least 18 years old to register');
            return;
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

        $user = config('roles.models.defaultUser')::create([
            'name' => $data['first_name']." ".$data['last_name'],
            'email' => $data['email'],
            'json' => json_encode($data),
            'dob' => $data['date_of_birth'] ?? '',
            'password' => bcrypt($data['password']),
        ]);

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
}
