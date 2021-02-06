<?php

namespace App\Console\Commands;

use App\PatientProfile;
use App\User;
use Illuminate\Console\Command;

class spool extends Command
{
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


            switch ($chain) {
                case 'pp':
                case 'patient_profile':

                    $this->info('patient_profile');

                    $bar = $this->output->createProgressBar(10);

                    $files = glob('/var/www/data/*');

                    $ctr = 0;

                    foreach ($files as $file) {

                        if (strpos($file, '@')) {

                            $ctr++;

                            try {

                                $json = file_get_contents($file);

                                $row = json_decode($json);

                                $em = $row->email;

                                $user = User::where('email', $em)->first();

                                $id = $user->id;

                                file_put_contents("work/pp/$id", $json);

                                $this->line("$ctr. $file => $id");

                            } catch (\Exception $e) {

                                $this->error($e->getMessage() . "\n" . $json);

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

    function upsertPatient($row)
    {

        $id = 0;

        $ctr = 0;

        $id = $row[$ctr++];
        $email = $row[$ctr++];
        $relationship_to_owner = $row[$ctr++];
        $first_name = $row[$ctr++];
        $last_name = $row[$ctr++];
        $birth_sex = $row[$ctr++];
        $date_of_birth = $row[$ctr++];
        $address1 = $row[$ctr++];
        $address2 = $row[$ctr++];
        $city = $row[$ctr++];
        $state = $row[$ctr++];
        $zipcode = $row[$ctr++];
        $ssn = $row[$ctr++];
        $dl_state = $row[$ctr++];
        $dl_number = $row[$ctr++];
        $ethnicity = $row[$ctr++];
        $race = $row[$ctr++];

        # instantiate a BurstIq class with optional username & password or use login() method later

        $P = new PatientProfile();

        $P->setAddress1($address1)
            ->setAddress2($address2)
            ->setCity($city)
            ->setDateOfBirth($date_of_birth)
            ->setDlNumber($dl_number)
            ->setDlState($dl_state)
            ->setEmail($email)
            ->setBirthSex(0)
            ->setEthnicity(0)
            ->setFirstName($first_name)
            ->setLastName($last_name)
            ->setRace(0)
            ->setVSeeClinicId('trackmysolutions')
            ->setRelationshipToOwner(0)
            ->setSsn($ssn)
            ->setState($state)
            ->setZipcode($zipcode)
            ->setId($id);

        # sub assets must be stored as arrays and all fields must be included even if they are not required

        $phone_number = $row[$ctr++];

        $phone_numbers = [
            [
                "is_primary" => "1",
                "phone_type" => "1",
                "phone_number" => $phone_number
            ],
            [
                "is_primary" => "0",
                "phone_type" => "2",
                "phone_number" => "8002822882"
            ]

        ];

        $insurances = [[
            "administrator_name" => "Bo Snerdley",
            "group_id" => "123456",
            "employer_name" => "EIB Network",
            "coverage_effective_date" => "1/1/2021",
            "issuer_id" => "654321",
            "primary_cardholder" => "$last_name, $first_name",
            "insurance_type" => 1,
            "relationship_to_primary_cardholder" => 0,
            "plan_type" => 2,
            "plan_id" => "",

        ]];


        $result = $P->setInsurances($insurances)
            ->setPhoneNumbers($phone_numbers)
            ->save();

        echo("<pre>$result</pre>");

    }


}
