<?php

namespace App;
use Illuminate\Http\Request;

/*
 * question_profile
question
is_active
begin_date
end_date
is_drug_question
is_testing_question
drug_id
 */

class QuestionProfile extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'question_profile';
    protected $view = 'biq/question_profile';

    # List all of the private vars here (id and other common ones are in the base class

    private $question;
    private $is_active;
    private $begin_date;
    private $end_date;
    private $is_drug_question;
    private $is_testing_question;
    private $drug_id;

    # Generate fluent getters and setters here


    # custom functions here

    public function make($record) {

        # example

        # get the full asset object

        $asset = $record->asset;

        # populate id and all the other properties

        $this->id = $asset->id;
        $this->question = $asset->question;
        $this->is_active = $asset->is_active;
        $this->begin_date = $asset->begin_date;
        $this->end_date = $asset->end_date;
        $this->is_drug_question = $asset->is_drug_question;
        $this->is_testing_question = $asset->is_testing_question;
        $this->drug_id = $asset->drug_id;


        # make a useful array of this row, for example:

        $array = [

            'id' => $asset->id,
            'question' => $asset->question,
            'is_active' => $asset->is_active,
            'begin_date' => $asset->begin_date,
            'end_date' => $asset->end_date,
            'is_drug_question' => $asset->is_drug_question,
            'is_testing_question' => $asset->is_testing_question,
            'drug_id' => $asset->drug_id,

        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }
}
