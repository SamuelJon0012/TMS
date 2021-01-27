<?php

namespace App;
use Illuminate\Http\Request;

/*
 * encounter_schedule
id
appointment_type
is_walkin
scheduled_time
patient_question_responses
	question_id
	patient_response
patient_id
site_id
provider_id
reminder
	type
	description
	scheduled
 */


class EncounterSchedule extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'encounter_schedule';
    protected $view = 'biq/encounter_schedule';

    # List all of the private vars here (id and other common ones are in the base class

    private $appointment_type;
    private $is_walkin;
    private $scheduled_time;
    private $patient_question_responses;
    private $patient_id;
    private $site_id;
    private $provider_id;
    private $reminder;

    /**
     * @return mixed
     */
    public function getAppointmentType()
    {
        return $this->appointment_type;
    }

    /**
     * @param mixed $appointment_type
     * @return EncounterSchedule
     */
    public function setAppointmentType($appointment_type)
    {
        $this->appointment_type = $appointment_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsWalkin()
    {
        return $this->is_walkin;
    }

    /**
     * @param mixed $is_walkin
     * @return EncounterSchedule
     */
    public function setIsWalkin($is_walkin)
    {
        $this->is_walkin = $is_walkin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScheduledTime()
    {

        return $this->scheduled_time;
    }

    /**
     * @param mixed $scheduled_time
     * @return EncounterSchedule
     */
    public function setScheduledTime($scheduled_time)
    {

        $this->scheduled_time = $scheduled_time;
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
     * @return EncounterSchedule
     */
    public function setPatientQuestionResponses($patient_question_responses)
    {
        $this->patient_question_responses = $patient_question_responses;
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
     * @return EncounterSchedule
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
     * @return EncounterSchedule
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
     * @return EncounterSchedule
     */
    public function setProviderId($provider_id)
    {
        $this->provider_id = $provider_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * @param mixed $reminder
     * @return EncounterSchedule
     */
    public function setReminder($reminder)
    {
        $this->reminder = $reminder;
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
        $this->appointment_type = $asset->appointment_type;
        $this->is_walkin = $asset->is_walkin;
        $this->scheduled_time = $asset->scheduled_time;
        $this->patient_question_responses = $asset->patient_question_responses;
        $this->patient_id = $asset->patient_id;
        $this->site_id = $asset->site_id;
        $this->provider_id = $asset->provider_id;
        $this->reminder = $asset->reminder;


        # make a useful array of this row, for example:

        $array = [

            'id' => $asset->id,
            'appointment_type' => $asset->appointment_type,
            'is_walkin' => $asset->is_walkin,
            'scheduled_time' => $asset->scheduled_time,
            'patient_question_responses' => $asset->patient_question_responses,
            'patient_id' => $asset->patient_id,
            'site_id' => $asset->site_id,
            'provider_id' => $asset->provider_id,
            'reminder' => $asset->reminder,

        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }
}
