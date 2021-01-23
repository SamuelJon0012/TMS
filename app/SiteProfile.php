<?php

namespace App;
use Illuminate\Http\Request;

/*
 * site_profile
name
vacinity_name
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
    private $vacinity_name;
    private $address1;
    private $address2;
    private $city;
    private $state;
    private $zipcode;
    private $county;

    # Generate fluent getters and setters here


    # custom functions here

    public function make($record) {

        # example

        # get the full asset object

        $asset = $record->asset;

        # populate id and all the other properties

        $this->id = $asset->id;
        $this->name = $asset->name;
        $this->vacinity_name = $asset->vacinity_name;
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
            'vacinity_name' => $asset->vacinity_name,
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
