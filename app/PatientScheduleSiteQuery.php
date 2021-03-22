<?php

namespace App;
use Illuminate\Http\Request;

class PatientScheduleSiteQuery extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'patient_profile';
    protected $view = 'biq/patient_profile';

    # List all of the private vars here (id and other common ones are in the base class

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
    private $phone_numbers; # Array of arrays [ is_primary / phone_type / phone_number ]
    private $insurances; # Array of arrays:

    ##schedule
    private $appointment_type;
    private $is_walkin;
    private $scheduled_time;
    private $patient_question_responses;
    private $patient_id;
    private $site_id;
    private $provider_id;
    private $reminder;

    ###Site
    private $site_name;
    private $site_vicinity_name;
    private $site_address1;
    private $site_address2;
    private $site_city;
    private $site_state;
    private $site_zipcode;
    private $site_county;



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
     * @return mixed
     */
    public function getRelationshipToOwner()
    {
        return $this->relationship_to_owner;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @return mixed
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * @return mixed
     */
    public function getDlState()
    {
        return $this->dl_state;
    }

    /**
     * @return mixed
     */
    public function getDlNumber()
    {
        return $this->dl_number;
    }

    /**
     * @return mixed
     */
    public function getEthnicity()
    {
        return $this->ethnicity;
    }

    /**
     * @return mixed
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumbers()
    {
        return $this->phone_numbers;
    }

    /**
     * @return mixed
     */
    public function getInsurances()
    {
        return $this->insurances;
    }

    ##schedule
    /**
     * @return mixed
     */
    public function getAppointmentType()
    {
        return $this->appointment_type;
    }

    /**
     * @return mixed
     */
    public function getIsWalkin()
    {
        return $this->is_walkin;
    }

    /**
     * @return mixed
     */
    public function getScheduledTime()
    {

        return $this->scheduled_time;
    }

    /**
     * @return mixed
     */
    public function getPatientQuestionResponses()
    {
        return $this->patient_question_responses;
    }

    /**
     * @return mixed
     */
    public function getPatientId()
    {
        return $this->patient_id;
    }

    /**
     * @return mixed
     */
    public function getSiteId()
    {
        return $this->site_id;
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->provider_id;
    }

    /**
     * @return mixed
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    ###Site
    /**
     * @return mixed
     */
    public function getSiteName()
    {
        return $this->site_name;
    }

    /**
     * @return mixed
     */
    public function getSiteVicinityName()
    {
        return $this->site_vicinity_name;
    }

    /**
     * @return mixed
     */
    public function getSiteAddress1()
    {
        return $this->site_address1;
    }

    /**
     * @return mixed
     */
    public function getSiteAddress2()
    {
        return $this->site_address2;
    }

    /**
     * @return mixed
     */
    public function getSiteCity()
    {
        return $this->site_city;
    }

    /**
     * @return mixed
     */
    public function getSiteState()
    {
        return $this->site_state;
    }

    /**
     * @return mixed
     */
    public function getSiteZipcode()
    {
        return $this->site_zipcode;
    }

    /**
     * @return mixed
     */
    public function getSiteCounty()
    {
        return $this->site_county;
    }


    public function make($record) {

        # get the full asset object

        $asset = $record->asset;

        $this->id = $asset->id;
        $this->email = $asset->email;
        $this->relationship_to_owner = $asset->relationship_to_owner;
        $this->first_name = $asset->first_name;
        $this->last_name = $asset->last_name;

        $this->birth_sex = '01/01/2000'; // $asset->birth_sex; #Todo not getting this

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
        $this->phone_numbers = $asset->phone_numbers;
        $this->insurances = $asset->insurance;
        ##schedule
        $this->appointment_type = $asset->appointment_type;
        $this->is_walkin = $asset->is_walkin;
        $this->scheduled_time = $asset->scheduled_time;
        $this->patient_question_responses = $asset->patient_question_responses;
        $this->patient_id = $asset->patient_id;
        $this->site_id = $asset->site_id;
        $this->provider_id = $asset->provider_id;
        $this->reminder = $asset->reminder;
        ###Site
        $this->site_name = $asset->site_name;
        $this->site_vicinity_name = $asset->vicinity_name;
        $this->site_address1 = $asset->site_address1;
        $this->site_address2 = $asset->site_address2;
        $this->site_city = $asset->site_city;
        $this->site_state = $asset->site_state;
        $this->site_zipcode = $asset->site_zipcode;
        $this->site_county = $asset->site_county;



        # make a useful array of this row

        $array = [

            'id' => $asset->id,
            'email' => $asset->email,
            'relationship_to_owner' => $asset->   relationship_to_owner,
            'first_name' => $asset->first_name,
            'last_name' => $asset->last_name,
            'birth_sex' => '01/01/2000', //  $asset->birth_sex, # Todo: not getting this
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
            'insurances' => $asset->insurance,
            ##schedule
            'appointment_type' => $asset->appointment_type,
            'is_walkin' => $asset->is_walkin,
            'scheduled_time' => $asset->scheduled_time,
            'patient_question_responses' => $asset->patient_question_responses,
            'patient_id' => $asset->patient_id,
            'site_id' => $asset->site_id,
            'provider_id' => $asset->provider_id,
            'reminder' => $asset->reminder,
            ###Site
            'site_name' => $asset->site_name,
            'site_vicinity_name' => $asset->site_vicinity_name,
            'site_address1' => $asset->site_address1,
            'site_address2' => $asset->site_address2,
            'site_city' => $asset->site_city,
            'site_state' => $asset->site_state,
            'site_zipcode' => $asset->site_zipcode,
            'site_county' => $asset->site_county,
        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }

}
