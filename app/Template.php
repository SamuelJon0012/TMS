<?php

namespace App;
use Illuminate\Http\Request;



class Template extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'chain_name';
    protected $view = 'biq/chain_name';

    # List all of the private vars here (id and other common ones are in the base class


    # Generate fluent getters and setters here


    # custom functions here

    public function make($record) {

        # example

        # get the full asset object

        $asset = $record->asset;

        # populate id and all the other properties

        $this->id = $asset->id;
//.. etc


        # make a useful array of this row, for example:

        $array = [

            'id' => $asset->id,
            'is_doctor' => $asset->is_doctor,
            'is_nurse' => $asset->is_nurse,
            'is_nurse_practitioner' => $asset->is_nurse_practitioner,
            'user_id' => $asset->user_id,
            'npi' => $asset->npi,
            'sites' => $asset->sites,

        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }
}
