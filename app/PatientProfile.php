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
    private $phone_numbers; # Array of arrays [ is_primary / phone_type / phone_number ]
    private $insurances; # Array of arrays:
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


        try {

            foreach ($insurances as $insurance) {

                $insurance = (array) $insurance;

                # cause an exception if any of these do not exist

                $insurances_array[] =
                [
                    'administrator_name' => $insurance['administrator_name'],
                    'group_id' => $insurance['group_id'],
                    'employer_name' => $insurance['employer_name'],
                    'coverage_effective_date' => $insurance['coverage_effective_date'],
                    'issuer_id' => $insurance['issuer_id'],
                    'primary_cardholder' => $insurance['primary_cardholder'],
                    'patient_profile_id' => $insurance['patient_profile_id'],
                    'insurance_type' => $insurance['insurance_type'],
                ];
            }
        } catch (\Exception $e) {

            throw new \Exception('Invalid insurances passed to setInsurances in PatientProfile. Parameter must be a string or an array of insirance objects');
        }

        $this->insurances = $insurances_array;
        return $this;
    }

    public function save() {

        // Create sub asset json strings, then assemble the whole body for posting

        // This should have been a blade like the others (idkwiwt)

        foreach ($this->phone_numbers as $phone_number) {

            $phone_numbers .= "{
                \"is_primary\":\"{$phone_number['is_primary']}\",
                \"phone_type\":\"{$phone_number['phone_type']}\",
                \"phone_number\": \"{$phone_number['phone_number']}\"
            },";
        }

        $phone_numbers = '[' . trim($phone_numbers, ',') . ']';

        $insurances = '';

        foreach ($this->insurances as $insurance) {

            $insurances .= "{
                \"administrator_name\":\"{$insurance['administrator_name']}\",
                \"group_id\":\"{$insurance['group_id']}\",
                \"employer_name\":\"{$insurance['employer_name']}\",
                \"coverage_effective_date\":\"{$insurance['coverage_effective_date']}\",
                \"issuer_id\":\"{$insurance['issuer_id']}\",
                \"primary_cardholder\":\"{$insurance['primary_cardholder']}\",
                \"patient_profile_id\":\"{$insurance['patient_profile_id']}\",
                \"insurance_type\": \"{$insurance['insurance_type']}\"
            },";

            $insurances = '[' . trim($insurances, ',') . ']';
        }

        $json = "{
            \"id\": \"$this->id\",
            \"email\": \"$this->email\",
            \"first_name\": \"$this->first_name\",
            \"last_name\": \"$this->last_name\",
            \"relationship_to_owner\": \"$this->relationship_to_owner\",
            \"date_of_birth\":\"$this->date_of_birth\",
            \"address1\":\"$this->address1\",
            \"address2\":\"$this->address2\",
            \"city\":\"$this->city\",
            \"state\":\"$this->state\",
            \"zipcode\":\"$this->zipcode\",
            \"ssn\":\"$this->ssn\",
            \"dl_state\":\"$this->dl_state\",
            \"dl_number\":\"$this->dl_number\",
            \"ethnicity\":\"$this->ethnicity\",
            \"race\":\"$this->race\",
            \"phone_numbers\": $phone_numbers,
            \"insurance\": $insurances
            }";

        #exit($json);

        return $this->upsert('patient_profile', $json);

    }

    public function make($record) {

        # get the full asset object

        $asset = $record->asset;

        # make a new BurstIq object for this record / row

        $O = new PatientProfile();

        # stick the needful into into this record / row

        $O->setJWT($this->getJwt())->setUsername($this->getUsername())->setPassword($this->getPassword());

        # set the properties of this record / row

        $O->asset_id = $record->asset_id;
        $O->insurances = $asset->insurance;
        $O->phone_numbers = $asset->phone_numbers;
        $O->id = $asset->id;
        $O->email = $asset->email;
        $O->relationship_to_owner = $asset->relationship_to_owner;
        $O->first_name = $asset->first_name;
        $O->last_name = $asset->last_name;
        $O->date_of_birth = $asset->date_of_birth;
        $O->address1 = $asset->address1;
        $O->address2 = $asset->address2;
        $O->city = $asset->city;
        $O->state = $asset->state;
        $O->zipcode = $asset->zipcode;
        $O->ssn = $asset->ssn;
        $O->dl_state = $asset->dl_state;
        $O->dl_number = $asset->dl_number;
        $O->ethnicity = $asset->ethnicity;
        $O->race = $asset->race;
        $O->data = $asset;
        $O->get = $asset;

        # add this row to the primary object's get[] array

            # This is a mess: I wanted to have the full object for each item in the array but I think it dereferences.
            # We'll have to get a single item by asset_id in order to save it

            //$this->get[] = $O;

        # make a useful array of this row FOR this row object

        $O->array = [

            'id' => $asset->id,
            'email' => $asset->email,
            'relationship_to_owner' => $asset->   relationship_to_owner,
            'first_name' => $asset->first_name,
            'last_name' => $asset->last_name,
            'date_of_birth' => $asset->date_of_birth,
            'address1' => $asset->address1,
            'address2' => $asset->address2,
            'city' => $asset->city,
            'state' => $asset->state,
            'zipcode' => $asset->zipcode,
            'ssn' => $asset->ssn,
            'dl_state' => $asset->dl_state,
            'dl_number' => $asset->dl_number,
            'ethnicity' => $asset->ethnicity,
            'race' => $asset->race,
            'phone_numbers' => $asset->phone_numbers,
            'insurances' => $asset->insurance

        ];

        # and APPEND this row's array to the primary object's array[] array

        $this->array[] = $O->array;

        # So now, each object in the get[] array has itselfs data amd array

    }

}
