<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\PatientProfile;
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
          if (request('r_type') == 'provider')
            return;

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
            if (strpos($email,'@')){
              if (!$emails = \json_decode(file_get_contents(public_path().'/email.json')))
                $validator->errors()->add('email', __('Failed to load list of valid emails'));
              if (!in_array($email, $emails)){
                $validator->errors()->add('email', __('This email is not on the authorized list'));
                $validator->errors()->add('emailPopup', 'Show'); //Triggers popup dialogue
              }
            }
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
            //'burstiq_private_id' => $patientProfile->newPrivateId(),
        ]);

        //Remove passwords
        unset($data['password']);
        unset($data['password_confirmation']);

        // backup spool
        file_put_contents('/var/www/data/' . $data['email'], json_encode($data));

        if($data['r_type']) {

          $role = config('roles.models.role')::where('slug', '=', $data['r_type'])->first();  //choose the default role upon user creation.

          if($role) {
              $user->attachRole($role);
          }

          //for BurstIq
          if($data['r_type'] == "patient") {
                //Call for inserting Patient Record in BurstIq

		

              # instantiate a BurstIq class with optional username & password or use login() method later

              # Dev private ID 8311ae006d91d9c7

              $P = new PatientProfile();

              $P->setAddress1($data['address1'])
                  ->setAddress2($data['address2'])
                  ->setCity($data['city'])
                  ->setDateOfBirth($data['date_of_birth'])
                  ->setDlNumber($data['dl_number'])
                  ->setDlState($data['dl_state'])
                  ->setEmail($data['email'])
                  ->setBirthSex($data['birth_sex'])
                  ->setEthnicity($data['ethnicity'])
                  ->setFirstName($data['first_name'])
                  ->setLastName($data['last_name'])
                  ->setRace($data['race'])
                  ->setVSeeClinicId('trackmysolutions')
                  // Todo: This is not in the registration form
                  //->setRelationshipToOwner($data['relationship_to_owner'])
                  //->setSsn($data['ssn'])
                  ->setState($data['state'])
                  ->setZipcode($data['zipcode'])
                  ->setId($user->id);

              # sub assets must be stored as arrays and all fields must be included even if they are not required

              $phone_number = $data['phone_number'];

              $phone_numbers= [ // Todo: fix registration form (it's sending "Mobile")
                  [
                      "is_primary" => "1",
                      "phone_type" => "1",
                      "phone_number" => $phone_number
                  ],
                    // Todo: Add 2nd phone number if they have it
              ];

              $insurances = [[ // We don't have this info yet (It's on the questionnaire)
                  "administrator_name" =>"Undefined",
                  "group_id" =>"0",
                  "employer_name" =>"Undefined",
                  "coverage_effective_date" =>"1/1/2021",
                  "issuer_id" =>"0000",
                  "primary_cardholder" => $data['first_name']." ".$data['last_name'],
                  "insurance_type" => 0,
                  "relationship_to_primary_cardholder" => 0,
                  "plan_type" => 0,
                  "plan_id" => "0",

              ]];


              $result = $P->setInsurances($insurances)
                  ->setPhoneNumbers($phone_numbers)
                  ->save();

          }

          if($data['r_type'] == "provider") {
            // Todo: Call for inserting Provider Record in BurstIq

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
