<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\VSee;
use App\PatientProfile;
use App\User;

class CompleteVisit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $patient_id;
    protected int $provider_id;
    protected int $timestamp;
    protected array $validStatuses = [VSee::STATUS_CONFIRMED=>2, VSee::STATUS_INPROGRESS=>1];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $patient_id, int $provider_id, int $timestamp)
    {
        $this->patient_id = $patient_id;
        $this->timestamp = $timestamp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get the current patient details from burst
        $patient = new PatientProfile();
        if (!$patient->load($this->patient_id))                                                               //#1
            return $this->fail('Invalid Patient ID');
        
        if ($o = (array)$patient->getDateOfBirth())
            $dob = substr($o['$date'], 0, 10);
        else
            $dob = null;

        $vsee = new VSee();

        $visits = $vsee->getVisits($patient->getFirstName(), $patient->getLastName(), $dob, $patient->getEmail());     //#2 + #3

        if (!$visits)
            return $this->fail('No VSee visit data');
        if (!$visits = json_decode($visits))
            return $this->fail('Invalid JSON returned from VSee');

        $minTime = strtotime('-2 hours', $this->timestamp);
        $maxTime = strtotime('+2 hours', $this->timestamp);

        $candidates = [];
        foreach($visits->data as $visit){
            if (
                (isset($this->validStatuses[$visit->status]))
                and (
                    ($visit->state == $vsee::STATUS_INPROGRESS)
                    or ( ($visit->start > $minTime) and ($visit->end < $maxTime) )
                )
            ) 
                $candidates[] = $visit;
        }

        if (empty($candidates))
            return // Nothing to do

        //sort candidates to get most likely
        usort($candidates, function($a,$b){
            $res = $this->validStatuses[$a->status] <=> $this->validStatuses[$b->status]; //In Progress is best
            if ($res != 0)
                return $res;
            return abs($a->start - $this->timestamp) <=> abs($b->start - $this->timestamp); //Closest to now
        });

        if ($visit->status == $vsee::STATUS_CONFIRMED){
            //Visit needs to be started first
            if ($err = $vsee->startVisit($visit->id))                                                            //#4a
                return $this->fail('VSee->startVisit returned '.$err);
        }

        $user = USER::findOrFail($provider_id);
        list($firstName, $lastName) = $user->getFirstAndLastNames();

        $vseeAdmin = new VSee();

        //Get a token for a provider
        $res = $vseeAdmin->getSSOToken($firstName, $lastName, '', $user->email, VSee::USERTYPE_PROVIDER);       //#4b
        if ((!$res) or (!isset($res->data->token->token)))
            return $this->fail('Failed to get provider SSOToken for '.$user->email);

        $vseeAdmin->token = $res->data->token->token; //Switch to provider's Token
        
        /* !!! Don't Do It - this could abort the visit !!!
        if ($err = $vseeAdmin->closeVisit($visit_id))                                                           //#5
            return $this->fail('VSee->closeVisit as provider returned '.$err);
        */

    }
}
