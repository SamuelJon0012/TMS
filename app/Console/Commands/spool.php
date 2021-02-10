<?php

namespace App\Console\Commands;

use App\PatientProfile;
use App\User;
use Illuminate\Console\Command;

class spool extends Command
{

    protected $P;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spool {chain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Spool data from lake to BurstIq';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $chain = $this->argument('chain');


        try {

            $this->info($chain);

            // Move all files from the lake into categorized subfolders named as the user id

            // pp = site registration form (files named as email)
            // i = questionnaire form (with insurance info and questions) (pq files_
            // vs = vsee SSO files
            // vswh = vsee webhooks

            // Do the i first to stage insurance info, then pp to load patient profiles


            switch ($chain) {
                case 'pp':
                case 'patient_profile':

                    $this->P = new PatientProfile;

                    $this->info('patient_profile');

                    $files = glob('/var/www/data/*');

                    $ctr = 0;

                    foreach ($files as $file) {

                        if (strpos($file, '@')) {

                        //if ($file == '/var/www/data/cmcochran@cbsd.org') {

                            $ctr++;

                           try {

                                $json = file_get_contents($file);

                                $row = json_decode($json);

                                $em = $row->email;

                                $user = User::where('email', $em)->first();

                                $id = $user->id;

                                #if ($id != 133) continue;

                                file_put_contents("work/pp/$id", $json);

                                if (file_exists("work/i/$id")) {

                                    // we can process this patient because an i exists

                                    $i = file_get_contents("work/i/$id");

                                    $result = $this->upsertPatient($id, $row, json_decode($i));

                                }


                                $this->line("$ctr. $file => $id $result");

                            } catch (\Exception $e) {

                                $this->error($e->getMessage() . "\n" . $json . "\n" . $i );

                                #exit;

                            }

                        }

                    }

                    break;

                case 'i':
                case 'insurance':

                    $this->info('insurance');

                    $files = glob('/var/www/data/pq*');

                    $ctr = 0;

                    foreach ($files as $file) {

                        $ctr++;

                        try {

                            $json = file_get_contents($file);

                            $row = json_decode($json);

                            $id = $row->user_id;

                            file_put_contents("work/i/$id", $json);

                            if ($row->q6 == 'Yes') {

                                $this->info('ALLERGIES!!!!!');

                                file_put_contents("/var/www/app/public/flags/q6/$id", $json);
                                file_put_contents("/var/www/erik/public/flags/q6/$id", $json);
                                file_put_contents("/var/www/dev/public/flags/q6/$id", $json);


                            }

                            $this->line("$ctr. $file => $id");

                        } catch (\Exception $e) {

                            $this->error($e->getMessage() . "\n" . $json);

                        }

                    }

                    break;



                case 'vswh':
                case 'vsee_webhook':

                    # There is going to be multiple webhooks for each patient.  Not sure how we want to approach this
                    # data.  There could be cancel / rebook / cancel / rebook etc

                    $this->info('vsee_webhook');

                    $files = glob('/var/www/data/vswh*');

                    $ctr = 0;

                    foreach ($files as $file) {

                        $ctr++;

                        try {

                            $json = file_get_contents($file);

                            $json = (json_decode($json));

                            # I had originally been json_encoding the already json_encoded webhook payload :\

                            if (gettype($json) == 'string') {
                                $json = json_decode($json);
                            }

                            $m = '';

                            $i = '';


                            if (isset($json->data->member_id)) {

                                $m = $json->data->member_id; // "13767783"

                                file_put_contents("work/vswh/m/$m", json_encode($json));

                                $this->line("$ctr. $file => $m m");

                            }
                            if (isset($json->data->id)) {

                                $i = $json->data->id;

                                file_put_contents("work/vswh/i/$i", json_encode($json));

                                $this->line("$ctr. $file => $i i");

                            }

                            $this->line("m=$m i=$i");

                        } catch (\Exception $e) {

                            $this->error($e->getMessage() . "\n" . json_encode($json));

                        }

                    }

                    break;

                # end switch
            }


        } catch
        (\Exception $e) {

            $this->error($e->getMessage());
        }


        return 0;
    }

    function upsertPatient($id, $row, $i)
    {

        $this->P->setAddress1($row->address1)
            ->setAddress2($row->address2)
            ->setCity($row->city)
            ->setDateOfBirth($row->date_of_birth)
            ->setDlNumber($row->dl_number)
            ->setDlState($row->dl_state)
            ->setEmail($row->email)
            ->setBirthSex($row->birth_sex)
            ->setEthnicity($row->ethnicity)
            ->setFirstName($row->first_name)
            ->setLastName($row->last_name)
            ->setRace($row->race)
            ->setVSeeClinicId('trackmysolutions')
            ->setRelationshipToOwner(0)
            ->setSsn($row->ssn)
            ->setState($row->state)
            ->setZipcode($row->zipcode)
            ->setId($id)
            ;

        # sub assets must be stored as arrays and all fields must be included even if they are not required

        $phone_numbers = [
            [
                "is_primary" => "1",
                "phone_type" => "1",
                "phone_number" => $row->phone_number
            ],

        ];

        //if (!empty($row->phone_number1))

        $a = [];

        if (empty($i->coverage_effective_date)) {
            $i->coverage_effective_date = '2021-01-01';
        }

        if (!empty($i->administrator_name)) $a["administrator_name"] = $i->administrator_name;
        if (!empty($i->group_id)) $a["group_id"] = $i->group_id;
        if (!empty($i->employer_name)) $a["employer_name"] = $i->employer_name;
        if (!empty($i->coverage_effective_date)) $a["coverage_effective_date"] = $i->coverage_effective_date;
        if (!empty($i->issuer_id)) $a["issuer_id"] = $i->issuer_id;
        if (!empty($i->primary_cardholder)) $a["primary_cardholder"] = $i->primary_cardholder;
        if (!empty($i->insurance_type)) $a["insurance_type"] = $i->insurance_type;
        if (!empty($i->relationship_to_primary_cardholder)) $a["relationship_to_primary_cardholder"] = $i->relationship_to_primary_cardholder;
        if (!empty($i->plan_type)) $a["plan_type"] = $i->plan_type;
        if (!empty($i->plan_id)) $a["plan_id"] = $i->plan_id;

        if ($a !== []) {
            $insurances = [ (object)$a ];
            $this->P->setInsurances($insurances);
        }

        $result = $this->P
            ->setPhoneNumbers($phone_numbers)
            ->save();

        return $result;

    }


}
