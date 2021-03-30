<?php

namespace App\Services;

use App\PatientProfile;
use App\Traits\Singleton;

class BurstIqService {
    use Singleton;

    public function createPatientProfile($data) {
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
            ->setIsWelcomed(false)
            ->setPatientConsented(false)
            ->setId($data['id'])
            ->setRelationshipToOwner(0)
            ->setMiddleName("")
            ->setCustomerProductId(2);

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

        return $P->setInsurances($insurances)
            ->setPhoneNumbers($phone_numbers)
            ->save();
    }
}
