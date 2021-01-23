<?php

namespace App;
use Illuminate\Http\Request;

/*
 * procedure_results
id
encounter_id
procedure_id
 */

class ProcedureResults extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'procedure_results';
    protected $view = 'biq/procedure_results';

    # List all of the private vars here (id and other common ones are in the base class

    private $encounter_id;
    private $procedure_id;

    /**
     * @return mixed
     */
    public function getEncounterId()
    {
        return $this->encounter_id;
    }

    /**
     * @param mixed $encounter_id
     * @return ProcedureResults
     */
    public function setEncounterId($encounter_id)
    {
        $this->encounter_id = $encounter_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProcedureId()
    {
        return $this->procedure_id;
    }

    /**
     * @param mixed $procedure_id
     * @return ProcedureResults
     */
    public function setProcedureId($procedure_id)
    {
        $this->procedure_id = $procedure_id;
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
        $this->encounter_id = $asset->encounter_id;
        $this->procedure_id = $asset->procedure_id;


        # make a useful array of this row, for example:

        $array = [

            'id' => $asset->id,
            'encounter_id' => $asset->encounter_id,
            'procedure_id' => $asset->procedure_id,

        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }
}
