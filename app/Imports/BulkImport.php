<?php

namespace App\Imports;

use App\Notifications\ConfirmPasswordNotification;
use App\Notifications\RegistrationNotification;
use App\PatientProfile;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BulkImport implements ToCollection, WithHeadingRow, SkipsOnError, SkipsOnFailure
{

    use SkipsErrors;
    use SkipsFailures;
    /** @var User */
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection($rows) {
        $token = false;
        if (count($rows) > 0)  {
            foreach ($rows as $row) {
                if (!isset($row["email"])) break;

                $email = trim($row["email"]);
                $validator = Validator::make([$email], [
                    0 => "required|unique:users,email"
                ]);

                if ($validator->fails())
                    continue;

                $data = [];
                foreach ($row as $k => $r) {
                    $data[$k] = (gettype($r) === "string") ? trim($r): $r;
                }
                $token = Str::random(90);
                $user = User::create([
                    "name" =>  $row["first_name"] . " " . $row["last_name"],
                    "email" => $email,
                    "token" => $token,
                    "password" => Hash::make("123456789"),
                    "json" => json_encode($data),
                    "dob" => date('Y/m/d',strtotime($row["date_of_birth"])),
                    "phone" => $row["phone_number"],
                ]);

                $data['id'] = $user->id;

                $binary = base64_encode(json_encode([
                    "email" => $row["email"],
                    "token" => $token
                ]));

                $user->notify(new ConfirmPasswordNotification($binary));

                $this->createPatientProfile($data);
            }
        }

        return $token;
    }

    private function getRowDataFromExcel($row = []){
        if(app()->getLocale() == 'en'){
            return [
                'store_code' => $row['store_code'] ?? '',
                'name' => $row['location_name'] ?? '',
                'website' => $row['website'] ?? '',
                'phone' => $row['phone'] ?? '',
                'address' => $row['address'] ?? '',
                'country' => $row['country'] ?? '',
                'province' => $row['province'] ?? '',
                'city' => $row['city'] ?? '',
                'postal_code' => $row['postal_code'] ?? '',
                'category_id' => $row['business_category'] ?? null,
                'lat' => $row['latitude'] ?? null,
                'lng' => $row['longitude'] ?? null,
            ];
        }
        else{
            return [
                'store_code' => $row['rmz_almokaa'] ?? '',
                'name' => $row['esm_almokaa'] ?? '',
                'website' => $row['almokaa_alelktrony']  ?? '',
                'phone' => $row['alhatf'] ?? '',
                'address' => $row['alaanoan'] ?? '',
                'country' => $row['albld'] ?? '',
                'province' => $row['almhafth']  ?? '',
                'city' =>  $row['almdyn']  ?? '',
                'postal_code' => $row['alrmz_albrydy']  ?? '',
                'category_id' => $row['fe_alaaml']  ?? null,
                'lat' => $row['ehdathyat_kht_alaard'] ?? null,
                'lng' => $row['ehdathyat_kht_altol']  ?? null,
            ];
        }

    }

    private function validateData($row){
        return true;
    }
    private function validateStoreCode($datas){
        $locale = app()->getLocale();
        $storeCodes = [];
        foreach($datas as $key => $value){
            if($locale == 'en'){
                if($value['store_code']){
                    $storeCodes[] = $value['store_code'];
                }
            }
            else{
                if($value['rmz_almokaa']){
                    $storeCodes[] = $value['rmz_almokaa'];
                }
            }
        }
        $storeCodesUnique = array_unique($storeCodes);
        if(count($storeCodesUnique) !== count($storeCodes)){
            return false;
        }
        return true;
    }

    private function createPatientProfile($data) {
        $P = new PatientProfile();

        $P->setAddress1($data['address1'])
            ->setAddress2($data['address2'])
            ->setCity($data['city'])
            ->setDateOfBirth($data['date_of_birth'])
            ->setState($data['state_code'])
            ->setEmail($data['email'])
            ->setBirthSex($data['birth_sex'])
            ->setEthnicity($data['ethnicity'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setRace($data['race'])
            ->setVSeeClinicId('trackmysolutions')
            ->setRelationshipToOwner(0)
            ->setIsWelcomed(false)
            ->setPatientConsented(false)
            ->setZipcode($data['zipcode'])
            ->setId($data['id'])
            ->setCustomerProductId(env('CUSTOMER_ID'));

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
}