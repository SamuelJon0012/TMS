<?php

namespace App;
use Illuminate\Http\Request;

/*
 * procedure_results

encounter_id
procedure_id
patient_id
result
datetime
expiration_datetime
 */

class ProcedureResults extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'procedure_results';
    protected $view = 'biq/procedure_results';

    # List all of the private vars here (id and other common ones are in the base class

    private $encounter_id;
    private $procedure_id;
    private $patient_id;
    private $result;
    private $datetime;
    private $expiration_datetime;


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


    /**
     * @return mixed
     */

    public function getPatientId()
    {
        return $this->patient_id;
    }

    /**
     * @param mixed $patient_id
     * @return ProcedureResults
     */
    public function setPatientId($patient_id)
    {
        $this->patient_id = $patient_id;
        return $this;
    }



    /**
     * @return mixed
     */

    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     * @return ProcedureResults
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }


    /**
     * @return mixed
     */

    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param mixed $datetime
     * @return ProcedureResults
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }


    /**
     * @return mixed
     */

    public function getExpirationDatetime()
    {
        return $this->expiration_datetime;
    }

    /**
     * @param mixed $expiration_datetime
     * @return ProcedureResults
     */
    public function setExpirationDatetime($expiration_datetime)
    {
        $this->expiration_datetime = $expiration_datetime;
        return $this;
    }


    # custom functions here

    public function make($record) {

        # example

        # get the full asset object

        $asset = $record->asset;

        # populate id and all the other properties


        $this->encounter_id = $asset->encounter_id;
        $this->procedure_id = $asset->procedure_id;


        # make a useful array of this row, for example:

        $array = [


            'encounter_id' => $asset->encounter_id,
            'procedure_id' => $asset->procedure_id,

        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }

    public function isResultSet()
    {
        return $this->result == "" ? true : false;
    }
}
