<?php

namespace App;
use Illuminate\Http\Request;


class Guarantor {
    public $relationship_to_patient;
    public $first_name;
    public $last_name;
    public $prefix;
    public $suffix;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zipcode;
    public $date_of_birth;
    public $phone_number;
    public $customer_product_id;
    
    function __construct($source=null)
    {
        if (!empty($source))
            $this->assign($source);
    }

    protected function assign($source){
        if (empty($source)){
            $source = [];
        } 
        else if (is_string($source)){
            if(!$source = json_decode($source, true))
                throw new \Exception(json_last_error_msg());
        } 
        else if (is_object($source))
            $source = (array)$source;

        $vars = get_class_vars(get_class($this));
        foreach($vars as $name => $value)
            $this->{$name} = $source[$name] ?? null;
    }
}


class PatientProfile extends BurstIq
{
    # $this->status()
    # $this->query(chain, query)
    # $this->upsert(chain, postfields) accepts object or json_encoded object
    # see BurtIqController for examples

    protected $chain = 'patient_profile';
    protected $view = 'biq/patient_profile';

    private $email;
    private $relationship_to_owner;
    private $first_name;
    private $last_name;
    private $middle_name;
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
    private $customer_product_id;
    
    private ?Guarantor $guarantor = null;
    private $is_welcomed = false;
    private $patient_consented = false;

    static $RelationshipLookup = [
        0 => 'Associate',
        1 => 'Brother',
        2 => 'Care giver',
        3 => 'Child',
        4 => 'Handicapped dependent',
        5 => 'Life partner',
        6 => 'Emergency contact',
        7 => 'Employee',
        8 => 'Employer',
        9 => 'Extended family',
        10=> 'Foster child',
        11=> 'Friend',
        12=> 'Father',
        13=> 'Grandchild',
        14=> 'Guardian',
        15=> 'Grandparent',
        16=> 'Manager',
        17=> 'Mother',
        18=> 'Natural child',
        19=> 'None',
        20=> 'Other adult',
        21=> 'Other',
        22=> 'Owner',
        23=> 'Parent',
        24=> 'Stepchild',
        25=> 'Self',
        26=> 'Sibling',
        27=> 'Sister',
        28=> 'Spouse',
        29=> 'Trainer',
        30=> 'Unknown',
        31=> 'Ward of court',
    ];

    static $States = [
        'AK' => 'Alaska', 
        'AL' => 'Alabama', 
        'AR' => 'Arkansas', 
        'AZ' => 'Arizona', 
        'CA' => 'California', 
        'CO' => 'Colorado', 
        'CT' => 'Connecticut', 
        'DC' => 'District of Columbia', 
        'DE' => 'Delaware', 
        'FL' => 'Florida', 
        'GA' => 'Georgia', 
        'HI' => 'Hawaii', 
        'IA' => 'Iowa', 
        'ID' => 'Idaho', 
        'IL' => 'Illinois', 
        'IN' => 'Indiana', 
        'KS' => 'Kansas', 
        'KY' => 'Kentucky', 
        'LA' => 'Louisiana', 
        'MA' => 'Massachusetts', 
        'MD' => 'Maryland', 
        'ME' => 'Maine', 
        'MI' => 'Michigan', 
        'MN' => 'Minnesota', 
        'MO' => 'Missouri', 
        'MS' => 'Mississippi', 
        'MT' => 'Montana', 
        'NC' => 'North Carolina', 
        'ND' => 'North Dakota', 
        'NE' => 'Nebraska', 
        'NH' => 'New Hampshire', 
        'NJ' => 'New Jersey', 
        'NM' => 'New Mexico', 
        'NV' => 'Nevada', 
        'NY' => 'New York', 
        'OH' => 'Ohio', 
        'OK' => 'Oklahoma', 
        'OR' => 'Oregon', 
        'PA' => 'Pennsylvania', 
        'PR' => 'Puerto Rico', 
        'RI' => 'Rhode Island', 
        'SC' => 'South Carolina', 
        'SD' => 'South Dakota', 
        'TN' => 'Tennessee', 
        'TX' => 'Texas', 
        'UT' => 'Utah', 
        'VA' => 'Virginia', 
        'VT' => 'Vermont', 
        'WA' => 'Washington', 
        'WI' => 'Wisconsin', 
        'WV' => 'West Virginia', 
        'WY' => 'Wyoming', 
    ];

    static $EthnicityLookup = [
        0 => 'Hispanic or Latino',
        1 => 'Not Hispanic or Latino',
        2 => 'Unknown',
    ];

    static $RaceLookup = [
        1 => 'American Indian or Alaska Native',
        2 => 'Asian',
        3 => 'Black or African American',
        4 => 'Native Hawaiian or other Pacific Islander',
        5 => 'Other',
        6 => 'Patient Refused',
        7 => 'White or Caucasian',
    ];

    static $BirthSexLookup = [
        0 => 'Other',
        1 => 'Male',
        2 => 'Female',
        3 => 'Unknown',
        4 => 'Ambiguous',
        5 => 'Not Applicable',
    ];


    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->middle_name;
    }

    /**
     * @param mixed $middle_name
     * @return PatientProfile
     */
    public function setMiddleName($middle_name)
    {
        $this->middle_name = $middle_name;
        return $this;
    }

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
    
    public function getBirthSexByIndex($index){
        return static::$BirthSexLookup[$index];
    }
    
    public function getRaceByIndex($index){
        return static::$RaceLookup[$index];
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

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

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
     * @return mixed
     */
    public function getCustomerProductId()
    {
        return $this->customer_product_id;
    }
    
    public function getPatientConsented()
    {
        return $this->patient_consented;
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
     * @param mixed $customer_product_id
     * @return PatientProfile
     */
    public function setCustomerProductId($customer_product_id): PatientProfile
    {
        $this->customer_product_id = $customer_product_id;
        return $this;
    }
    
    
    /**
     * @param mixed $address1
     * @return PatientProfile
     */
    public function setPatientConsented($patient_consented): PatientProfile
    {
        $this->patient_consented = $patient_consented;
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

                $insurances_array[] =
                [
                    'administrator_name' => $insurance['administrator_name'] ?? '',
                    'group_id' => $insurance['group_id'] ?? '',
                    'employer_name' => $insurance['employer_name'] ?? '',
                    'coverage_effective_date' => '2021-01-01', // '$insurance['coverage_effective_date'] ?? '',
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

    public function getGuarantor(){
        return $this->guarantor;
    }
    
    public function setGuarantor($source){
        if ( (empty($source)) 
        or ((is_string($source)) and (strtolower($source) == 'null')) )
            $source = null;

        if ((is_a($source, 'Guarantor')) or ($source == null)){
            $this->guarantor = $source;
        } else {
            $this->guarantor = new Guarantor($source);
        }
        return $this;
    }

    public function getIsWelcomed(){
        return $this->is_welcomed;
    }

    public function setIsWelcomed(bool $value){
        $this->is_welcomed = $value;
        return $this;
    }


    public function make($record) {

        # get the full asset object

        $asset = $record->asset;

        $this->id = $asset->id ?? '?';
        $this->email = $asset->email ?? '?';
        $this->relationship_to_owner = $asset->relationship_to_owner ?? '?';
        $this->first_name = $asset->first_name ?? '?';
        $this->last_name = $asset->last_name ?? '?';
        $this->middle_name = $asset->middle_name ?? '?';

        $this->birth_sex = $asset->birth_sex ?? '?'; #Todo not getting this

        $this->date_of_birth = $asset->date_of_birth ?? '?';
        $this->address1 = $asset->address1 ?? '?';
        $this->patient_consented = $asset->patient_consented ?? false;
        
        $this->address2 = $asset->address2 ?? '?';
        $this->city = $asset->city ?? '?';
        $this->state = $asset->state ?? '?';
        $this->zipcode = $asset->zipcode ?? '?';
        $this->ssn = $asset->ssn ?? '?';
        $this->dl_state = $asset->dl_state ?? '?';
        $this->dl_number = $asset->dl_number ?? '?';
        $this->ethnicity = $asset->ethnicity ?? '?';
        $this->race = $asset->race ?? '?';
        $this->vsee_clinic_id = $asset->vsee_clinic_id ?? '?';
        $this->phone_numbers = $asset->phone_numbers ?? '?';
        $this->insurances = $asset->insurance ?? '?';
        $this->setGuarantor($asset->guarantor ?? null);
        $this->is_welcomed = $asset->is_welcomed ?? null;
        $this->patient_consented = $asset->patient_consented ?? null;
        $this->customer_product_id = $asset->customer_product_id ?? env('CUSTOMER_PRODUCT_ID');
        
        # make a useful array of this row

        $array = [

            'id' => $asset->id,
            'email' => $asset->email ?? '?',
            'relationship_to_owner' => $asset->   relationship_to_owner ?? '?',
            'first_name' => $asset->first_name ?? '?',
            'last_name' => $asset->last_name ?? '?',
            'middle_name' => $asset->middle_name ?? '?',
            'birth_sex' => $this->lookup['birth_sex'][$asset->birth_sex] ?? '?',
            'date_of_birth' => $asset->date_of_birth ?? '?',
            'address1' => $asset->address1 ?? '?',
            'patient_consented' => $asset->patient_consented ?? false,
            
            'address2' => $asset->address2 ?? '?',
            'city' => $asset->city ?? '?',
            'state' => $asset->state ?? '?',
            'zipcode' => $asset->zipcode ?? '?',
            'ssn' => $asset->ssn ?? '?',
            'dl_state' => $asset->dl_state ?? '?',
            'dl_number' => $asset->dl_number ?? '?',
            //'ethnicity' => $this->lookup['ethnicity'][$asset->ethnicity] ?? '?',
            'race' => $this->lookup['race'][$asset->race] ?? '?',
            'vsee_clinic_id' => $asset->vsee_clinic_id ?? '?',
            'phone_numbers' => $asset->phone_numbers ?? '?',
            'insurances' => $asset->insurance ?? '?',
            'guarantor' => $this->guarantor,
            'is_welcomed' => $asset->is_welcomed ?? null,
            'patient_consented' => $asset->patient_consented ?? null,
            'customer_product_id' => $asset->customer_product_id ?? env('CUSTOMER_PRODUCT_ID'),
        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;
    }

    function getPrimaryPhoneNumber(){
        if (!is_array($this->phone_numbers))
            return null;
        foreach($this->phone_numbers as $itm){
            if ($itm->is_primary)
                return $itm->phone_number;
        }
    }

    function getDateOfBirthText(){
        $txt = $this->date_of_birth->{'$date'} ?? null;
        return substr($txt, 0, 10);
    }

}
