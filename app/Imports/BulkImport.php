<?php

namespace App\Imports;

use App\Notifications\ConfirmPasswordNotification;
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
                    "password" => Hash::make(uniqid()),
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
            ->setZipcode($data['zipcode'])
            ->setIsWelcomed(true)
            ->setPatientConsented(true)
            ->setId($data['id']);

        $phone_number = $data['phone_number'];

        $phone_numbers= [
            [
                "is_primary" => "1",
                "phone_type" => "1",
                "phone_number" => $phone_number
            ],
        ];

        $insurances = [[
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

        try{
            $result = $P->setInsurances($insurances)
                ->setPhoneNumbers($phone_numbers)
                ->save();

            return $result;
        } catch (\Exception $e){
            dd($e->getMessage());
        }

    }
}
