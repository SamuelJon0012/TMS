<?php

namespace App\Console\Commands;

use App\BurstIq;
use App\Mail\EncounterProcedureResult;
use App\PatientProfile;
use Illuminate\Console\Command;
use App\Persist;
use App\ProcedureResults;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PollProcedureResults extends Command
{
    const PersistName = 'procedure_result.last_timestamp';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PollProcedureResults';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Polls the procedure_result chain for new records to be processed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int|string $value
     * @return string formated date time
     */
    function formatTimestamp($value){
        if (!is_numeric($value))
            $value = strtotime($value);
        return date('Y-m-d H:i:s', $value);
    }

    /**
     * Ensures only one instance of this script is running
     */
    function tryLock(){
        $this->_fileHandle = fopen(__FILE__, 'r');
        $wouldBlock = false;
        if (!flock($this->_fileHandle, LOCK_EX|LOCK_NB, $wouldBlock)){
            if ($wouldBlock)
                return false;
        }
        return true;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('--- '.date('c').' ---');
        
        if (!$this->tryLock()){
            $this->error('Script is already running');
            exit;
        }

        $lastDateTime = DB::table('procedure_results')->max('datetime');

        if (empty($lastDateTime))
            $lastDateTime = strtotime('-1 week');
        $lastDateTime = $this->formatTimestamp($lastDateTime);

        // fetch latest records from the chain
        $q = ["queryTqlFlow" => "WHERE asset.datetime >= Date('$lastDateTime') ORDER BY timestamp SELECT asset.* "]; //NOTE: Date not timestamp

        $api = new ProcedureResults();                                       //$api->curlLogFileName = storage_path('logs/procedure_results.log');
        $api->setEndPoint('/query/procedure_results');
        if ($err = $api->checkCurl($api->postCurl($q)))
            throw new \Exception($err);
        $records = $api->data->records;

        foreach($records as $rec){
            try {
                $dateTime = $this->formatTimestamp($rec->datetime->{'$date'});

                //Get or insert local procedure_results record
                $row = DB::table('procedure_results')
                    ->where('encounter_id',$rec->encounter_id)
                    ->where('procedure_id',$rec->procedure_id)
                    ->first();

                if (!$row){
                    $row = [
                        'encounter_id'        => $rec->encounter_id,
                        'procedure_id'        => $rec->procedure_id,
                        'patient_id'          => $rec->patient_id,
                        'result'              => $rec->result,
                        'datetime'            => $dateTime,
                        'expiration_datetime' => $this->formatTimestamp($rec->expiration_datetime->{'$date'}),
                        'email_sent_at'       => null,
                    ];
                    DB::table('procedure_results')->insert($row);
                    $row = (object)$row;
                }

                //Check if we have send an email for this before
                if ($row->email_sent_at){
                    $this->info("{$rec->encounter_id}-{$rec->procedure_id}: SKIP");
                    continue;
                }

                //Get the patients details
                $patient = new PatientProfile();
                if (!$patient->load($rec->patient_id))
                    throw new \Exception('Faile to fetch patient record');
                
                //Send the email
                $email = new EncounterProcedureResult($patient->getFirstName());
                $email->subject(__('New Test Result Notification')); //TODO: get patient's language and attempt to translate
                Mail::to($patient->getEmail())->send($email);

                //Update when the email was sent
                DB::table('procedure_results')
                    ->where('encounter_id',$rec->encounter_id)
                    ->where('procedure_id',$rec->procedure_id)
                    ->update(['email_sent_at'=>$this->formatTimestamp(time())]);

                //Commit
                $this->info("{$rec->encounter_id}-{$rec->procedure_id}: OK");
                DB::commit();

            } catch(\Exception $e){
                DB::rollBack();
                $this->error("{$rec->encounter_id}-{$rec->procedure_id}: ".$e->getMessage());
            }
        }

        return 0;
    }
}
