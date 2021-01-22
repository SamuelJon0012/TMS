<?php

namespace App;
use Illuminate\Http\Request;



class ProviderProfile extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqController for examples

    protected $chain = 'provider_profile';
    protected $view = 'biq/provider_profile';

    # List all of the private vars here (id and other common ones are in the base class)
    private $is_doctor;
    private $is_nurse;
    private $is_nurse_practitioner;
    private $user_id;
    private $sites = [];

    /**
     * @return mixed
     */
    public function getIsDoctor()
    {
        return $this->is_doctor;
    }

    /**
     * @param mixed $is_doctor
     * @return PatientProfile
     */
    public function setIsDoctor($is_doctor)
    {
        $this->is_doctor = $is_doctor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsNurse()
    {
        return $this->is_nurse;
    }

    /**
     * @param mixed $is_nurse
     * @return PatientProfile
     */
    public function setIsNurse($is_nurse)
    {
        $this->is_nurse = $is_nurse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsNursePractitioner()
    {
        return $this->is_nurse_practitioner;
    }

    /**
     * @param mixed $is_nurse_practitioner
     * @return PatientProfile
     */
    public function setIsNursePractitioner($is_nurse_practitioner)
    {
        $this->is_nurse_practitioner = $is_nurse_practitioner;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     * @return PatientProfile
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return array
     */
    public function getSites(): array
    {
        return $this->sites;
    }

    /**
     * @param array $sites
     * @return PatientProfile
     */
    public function setSites(array $sites): PatientProfile
    {
        $this->sites = $sites;
        return $this;
    }

    # Generate fluent getters and setters here



    # custom functions here


    public function make($record) {

        $asset = $record->asset;

        $class = get_class();

        $O = new $class;

        # This is gay

        #$O->setJWT($this->getJwt())->setUsername($this->getUsername())->setPassword($this->getPassword());

        # Todo add $asset_id to this class





    }



}
