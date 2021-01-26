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
    private $npi;
    private $sites = [];

    # Generate fluent getters and setters here

    /**
     * @return mixed
     */
    public function getNpi()
    {
        return $this->npi;
    }

    /**
     * @param mixed $npi
     * @return ProviderProfile
     */
    public function setNpi($npi)
    {
        $this->npi = $npi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsDoctor()
    {
        return $this->is_doctor;
    }

    /**
     * @param mixed $is_doctor
     * @return ProviderProfile
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
     * @return ProviderProfile
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
     * @return ProviderProfile
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
     * @return ProviderProfile
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
     * @return ProviderProfile
     */
    public function setSites(array $sites): ProviderProfile
    {
        $this->sites = $sites;
        return $this;
    }


    # custom functions here


    public function make($record) {

        # get the full asset object

        $asset = $record->asset;

        $this->id = $asset->id;
        $this->is_doctor = $asset->is_doctor;
        $this->is_nurse = $asset->is_nurse;
        $this->is_nurse_practitioner = $asset->is_nurse_practioner;
        #Todo $this->user_id = $asset->user_id; ?? not in collection?
        $this->npi = $asset->npi;
        $this->sites = $asset->sites;

        # make a useful array of this row

        $array = [

            'id' => $asset->id,
            'is_doctor' => $asset->is_doctor,
            'is_nurse' => $asset->is_nurse,
            'is_nurse_practitioner' => $asset->is_nurse_practioner,
            #Todo see above 'user_id' => $asset->user_id,
            'npi' => $asset->npi,
            'sites' => $asset->sites,

        ];



        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }

}
