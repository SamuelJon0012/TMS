<?php

namespace App;
use Illuminate\Http\Request;

/*
 * site_profile
name
vicinity_name
address1
address2
city
state
zipcode
county
 */

class SiteProfile extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'site_profile';
    protected $view = 'biq/site_profile';

    # List all of the private vars here (id and other common ones are in the base class

    private $name;
    private $vicinity_name;
    private $address1;
    private $address2;
    private $city;
    private $state;
    private $zipcode;
    private $county;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return SiteProfile
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVicinityName()
    {
        return $this->vicinity_name;
    }

    /**
     * @param mixed $vicinity_name
     * @return SiteProfile
     */
    public function setVicinityName($vicinity_name)
    {
        $this->vicinity_name = $vicinity_name;
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
     * @return SiteProfile
     */
    public function setAddress1($address1)
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
     * @return SiteProfile
     */
    public function setAddress2($address2)
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
     * @return SiteProfile
     */
    public function setCity($city)
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
     * @return SiteProfile
     */
    public function setState($state)
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
     * @return SiteProfile
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param mixed $county
     * @return SiteProfile
     */
    public function setCounty($county)
    {
        $this->county = $county;
        return $this;
    }

    # Generate fluent getters and setters here



    # custom functions here

    public function make($record) {

        # example

        # get the full asset object

        $asset = $record->asset;

        # populate id and all the other properties

        $this->id = $asset->id;
        $this->name = $asset->name;
        $this->vicinity_name = $asset->vicinity_name;
        $this->address1 = $asset->address1;
        $this->address2 = $asset->address2;
        $this->city = $asset->city;
        $this->state = $asset->state;
        $this->zipcode = $asset->zipcode;
        $this->county = $asset->county;



        # make a useful array of this row, for example:

        $array = [

            'id' => $asset->id,
            'name' => $asset->name,
            'vicinity_name' => $asset->vicinity_name,
            'address1' => $asset->address1,
            'address2' => $asset->address2,
            'city' => $asset->city,
            'state' => $asset->state,
            'zipcode' => $asset->zipcode,
            'county' => $asset->county,

        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }
}
