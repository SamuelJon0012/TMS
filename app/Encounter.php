<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
 * encounter
id
patient_id
site_id
provider_id
datetime
dx_icd10
referring_provider_id
patient_question_responses
	question_id
	patient_response
billing_provider_id
procedures
	id
	rendering_provider_id
	cpt
	reference_number
	model_version_number
	vendor
	erp_number
	tracking_tag_number
	manufacturer
	udi
	udi_di
	description
	lot_number
	serial_number
	manufacturing_date
	expiration_date
	model_version_number
	dose_number
	dose_date
	size
 */

class Encounter extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'encounter';
    protected $view = 'biq/encounter';

    # List all of the private vars here (id and other common ones are in the base class

    private $patient_id;
    private $site_id;
    private $provider_id;
    private $datetime;
    private $dx_icd10;
    private $referring_provider_id;
    private $patient_question_responses;
    private $billing_provider_id;
    private $procedures;
    private $type;
    private $customer_product_id;

    const EncounterType_COVIDTest  = 0;
    const EncounterType_Vaccine    = 1;
    const EncounterType_Telehealth = 2;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Encounter
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return Encounter
     */
    public function setPatientId($patient_id)
    {
        $this->patient_id = $patient_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSiteId()
    {
        return $this->site_id;
    }

    /**
     * @param mixed $site_id
     * @return Encounter
     */
    public function setSiteId($site_id)
    {
        $this->site_id = $site_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->provider_id;
    }

    /**
     * @param mixed $provider_id
     * @return Encounter
     */
    public function setProviderId($provider_id)
    {
        $this->provider_id = $provider_id;
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
     * @return Encounter
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDxIcd10()
    {
        return $this->dx_icd10;
    }

    /**
     * @param mixed $dx_icd10
     * @return Encounter
     */
    public function setDxIcd10($dx_icd10)
    {
        $this->dx_icd10 = $dx_icd10;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferringProviderId()
    {
        return $this->referring_provider_id;
    }

    /**
     * @param mixed $referring_provider_id
     * @return Encounter
     */
    public function setReferringProviderId($referring_provider_id)
    {
        $this->referring_provider_id = $referring_provider_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPatientQuestionResponses()
    {
        return $this->patient_question_responses;
    }

    /**
     * @param mixed $patient_question_responses
     * @return Encounter
     */
    public function setPatientQuestionResponses($patient_question_responses)
    {
        $this->patient_question_responses = $patient_question_responses;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingProviderId()
    {
        return $this->billing_provider_id;
    }

    /**
     * @param mixed $billing_provider_id
     * @return Encounter
     */
    public function setBillingProviderId($billing_provider_id)
    {
        $this->billing_provider_id = $billing_provider_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProcedures()
    {
        return $this->procedures;
    }

    /**
     * @param mixed $procedures
     * @return Encounter
     */
    public function setProcedures($procedures)
    {
        $this->procedures = $procedures;
        return $this;
    }

    public function getCustomerProductId(){
        return $this->customer_product_id;
    }

    public function setCustomerProductId($value): self{
        $this->customer_product_id = $value;
        return $this;
    }

    /**
     * get the next available id from the barcode table which is used as the asset.id for non barcode encounters
     * @return int
     */
    public function nextId(){
        $barcodes = DB::table('barcodes');
        //remove junk
        $barcodes->where('uniq_id','temp');
        //Insert record
        $id = $barcodes->insertGetId([
            'barcode'=>'temp',
            'uniq_id'=>'temp',
            'email'=>'temp@temp',
            'timestamp'=>'2020-01-01',
        ]);
        if (!$id)
            throw new \Exception('Failed to get next barcode ID');
        //remove inserted record
        $barcodes->delete($id);
        return $id;
    }

    # Generate fluent getters and setters here



    # custom functions here

    public function make($record) {

        # example

        # get the full asset object

        $asset = $record->asset;

        # populate id and all the other properties

        $this->id = $asset->id;
        $this->patient_id = $asset->patient_id;
        $this->site_id = $asset->site_id;
        $this->provider_id = $asset->provider_id;
        $this->datetime = $asset->datetime;
        $this->dx_icd10 = $asset->dx_icd10 ?? null;
        $this->referring_provider_id = $asset->referring_provider_id ?? null;
        $this->patient_question_responses = $asset->patient_question_responses;
        $this->billing_provider_id = $asset->billing_provider_id;
        $this->procedures = $asset->procedures;
        $this->customer_product_id = $asset->customer_product_id ?? null;


        # make a useful array of this row, for example:

        $array = [

            'id' => $asset->id,
            'patient_id' => $asset->patient_id,
            'site_id' => $asset->site_id,
            'provider_id' => $asset->provider_id,
            'datetime' => $asset->datetime,
            'dx_icd10' => $asset->dx_icd10 ?? null,
            'referring_provider_id' => $asset->referring_provider_id ?? null,
            'patient_question_responses' => $asset->patient_question_responses,
            'billing_provider_id' => $asset->billing_provider_id,
            'procedures' => $asset->procedures,
            'customer_product_id' => $asset->customer_product_id ?? null,
        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }
}
