<?php

namespace App;
use Illuminate\Http\Request;



class PatientProfile extends BurstIq
{

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, postfields) accepts object or json_encoded object
    # see BurtIqController for examples

    protected $chain = 'patient_profile';
    protected $view = 'biq/patient_profile';

    private $email;
    private $relationship_to_owner;
    private $first_name;
    private $last_name;
    private $date_of_birth;
    private $birth_sex;
    private $address1;
    private $address2;
    private $city;
    private $state;
    private $zipcode;
    private $ssn;
    private $dl_state;
    private $dl_number;
    private $ethnicity;
    private $race;
    private $vsee_clinic_id;
    private $phone_numbers; # Array of arrays [ is_primary / phone_type / phone_number ]
    private $insurances;

    /**
     * @return mixed
     */
    public function getVseeClinicId()
    {
        return $this->vsee_clinic_id;
    }

    /**
     * @param mixed $vsee_clinic_id
     * @return PatientProfile
     */
    public function setVseeClinicId($vsee_clinic_id)
    {
        $this->vsee_clinic_id = $vsee_clinic_id;
        return $this;
    } # Array of arrays:
    /*
        administrator_name
        group_id
        employer_name
        coverage_effective_date
        issuer_id
        primary_cardholder
        patient_profile_id
        insurance_type
     */


    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getBirthSex()
    {
        return $this->birth_sex;
    }

    /**
     * @param mixed $birth_sex
     * @return PatientProfile
     */
    public function setBirthSex($birth_sex)
    {
        $this->birth_sex = $birth_sex;
        return $this;
    }

    /**
     * @param mixed $url
     * @return PatientProfile
     */
    public function setUrl($url): PatientProfile
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return PatientProfile
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelationshipToOwner()
    {
        return $this->relationship_to_owner;
    }

    /**
     * @param mixed $relationship_to_owner
     * @return PatientProfile
     */
    public function setRelationshipToOwner($relationship_to_owner): PatientProfile
    {
        $this->relationship_to_owner = $relationship_to_owner;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return PatientProfile
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return PatientProfile
     */
    public function setLastName($last_name): PatientProfile
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @param mixed $date_of_birth
     * @return PatientProfile
     */
    public function setDateOfBirth($date_of_birth): PatientProfile
    {
        $this->date_of_birth = $date_of_birth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     * @return PatientProfile
     */
    public function setAddress1($address1): PatientProfile
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     * @return PatientProfile
     */
    public function setAddress2($address2): PatientProfile
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return PatientProfile
     */
    public function setCity($city): PatientProfile
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return PatientProfile
     */
    public function setState($state): PatientProfile
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     * @return PatientProfile
     */
    public function setZipcode($zipcode): PatientProfile
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * @param mixed $ssn
     * @return PatientProfile
     */
    public function setSsn($ssn)
    {
        $this->ssn = $ssn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDlState()
    {
        return $this->dl_state;
    }

    /**
     * @param mixed $dl_state
     * @return PatientProfile
     */
    public function setDlState($dl_state): PatientProfile
    {
        $this->dl_state = $dl_state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDlNumber()
    {
        return $this->dl_number;
    }

    /**
     * @param mixed $dl_number
     * @return PatientProfile
     */
    public function setDlNumber($dl_number): PatientProfile
    {
        $this->dl_number = $dl_number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEthnicity()
    {
        return $this->ethnicity;
    }

    /**
     * @param mixed $ethnicity
     * @return PatientProfile
     */
    public function setEthnicity($ethnicity): PatientProfile
    {
        $this->ethnicity = $ethnicity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param mixed $race
     * @return PatientProfile
     */
    public function setRace($race)
    {
        $this->race = $race;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumbers()
    {
        return $this->phone_numbers;
    }

    /**
     * @param mixed $phone_numbers
     * @return PatientProfile
     *
     * Array of arrays or objects [ is_primary / phone_type / phone_number ]
     *
     * @throws \Exception
     */
    public function setPhoneNumbers($phone_numbers): PatientProfile
    {

        $phone_numbers_array = [];

        try {

            foreach ($phone_numbers as $phone_number) {

                $phone_number = (array) $phone_number;

                # cause an exception if any of these do not exist

                $phone_numbers_array[] =
                [
                    'is_primary' => $phone_number['is_primary'],
                    'phone_type' => $phone_number['phone_type'],
                    'phone_number' => $phone_number['phone_number']
                ];
            }
        } catch (\Exception $e) {

            throw new \Exception('Invalid phone numbers passed to setPhoneNumbers in PatientProfile. Parameter must be a string or an array of phone number objects');
        }

        $this->phone_numbers = $phone_numbers_array;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInsurances()
    {
        return $this->insurances;
    }

    /**
     * @param mixed $insurances
     * @return PatientProfile
     *
     * Array of arrays or objects
     *
     * @throws \Exception
     */
    public function setInsurances($insurances): PatientProfile
    {

        $insurances_array = [];


        try {var_dump($insurances);

            foreach ($insurances as $insurance) {

                $insurance = (array) $insurance;

                # cause an exception if any of these do not exist

                $insurances_array[] =
                [
                    'administrator_name' => $insurance['administrator_name'] ?? '',
                    'group_id' => $insurance['group_id'] ?? '',
                    'employer_name' => $insurance['employer_name'] ?? '',
                    'coverage_effective_date' => $insurance['coverage_effective_date'] ?? '',
                    'issuer_id' => $insurance['issuer_id'] ?? '',
                    'primary_cardholder' => $insurance['primary_cardholder'] ?? '',
                    'relationship_to_primary_cardholder' => $insurance['relationship_to_primary_cardholder']  ?? '',
                    'insurance_type' => $insurance['insurance_type'] ?? '',
                    'plan_type' => $insurance['plan_type'] ?? '',
                    'plan_id' => $insurance['plan_id'] ?? '',
                ];
            }
        } catch (\Exception $e) {

            throw new \Exception('Invalid insurances passed to setInsurances in PatientProfile. Parameter must be a string or an array of insurance objects: ' . $e->getMessage());
        }

        $this->insurances = $insurances_array;
        return $this;
    }

    public function make($record) {

        # get the full asset object

        $asset = $record->asset;

        $this->id = $asset->id;
        $this->email = $asset->email;
        $this->relationship_to_owner = $asset->relationship_to_owner;
        $this->first_name = $asset->first_name;
        $this->last_name = $asset->last_name;

        $this->birth_sex = $asset->birth_sex; #Todo not getting this

        $this->date_of_birth = $asset->date_of_birth;
        $this->address1 = $asset->address1;
        $this->address2 = $asset->address2;
        $this->city = $asset->city;
        $this->state = $asset->state;
        $this->zipcode = $asset->zipcode;
        $this->ssn = $asset->ssn;
        $this->dl_state = $asset->dl_state;
        $this->dl_number = $asset->dl_number;
        $this->ethnicity = $asset->ethnicity;
        $this->race = $asset->race;
        $this->vsee_clinic_id = $asset->vsee_clinic_id;
        $this->phone_numbers = $asset->phone_numbers;
        $this->insurances = $asset->insurance;

        # make a useful array of this row

        $array = [

            'id' => $asset->id,
            'email' => $asset->email,
            'relationship_to_owner' => $asset->   relationship_to_owner,
            'first_name' => $asset->first_name,
            'last_name' => $asset->last_name,
            'birth_sex' => $this->lookup['birth_sex'][$asset->birth_sex],
            'date_of_birth' => $asset->date_of_birth,
            'address1' => $asset->address1,
            'address2' => $asset->address2,
            'city' => $asset->city,
            'state' => $asset->state,
            'zipcode' => $asset->zipcode,
            'ssn' => $asset->ssn,
            'dl_state' => $asset->dl_state,
            'dl_number' => $asset->dl_number,
            //'ethnicity' => $this->lookup['ethnicity'][$asset->ethnicity] . '(' . $asset->ethnicity . ')',
            'race' => $this->lookup['race'][$asset->race] . '(' . $asset->race . ')',
            'vsee_clinic_id' => $asset->vsee_clinic_id,
            'phone_numbers' => $asset->phone_numbers,
            'insurances' => $asset->insurance

        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }

}
