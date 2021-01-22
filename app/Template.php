<?php

namespace App;
use Illuminate\Http\Request;



class PatientProfile extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqController for examples

    protected $chain = 'provider_profile';
    protected $view = 'biq/provider_profile';

    # List all of the private vars here (id and other common ones are in the base class


    # Generate fluent getters and setters here


    # custom functions here

    public function make($record) {


        # get the full asset object

        $asset = $record->asset;


        # make a useful array of this row

        $array = [

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

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;


    }

    private $get, $first, $array; # ? base class?

}
