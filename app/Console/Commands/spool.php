<?php

namespace App\Console\Commands;

use App\PatientProfile;
use App\User;
use App\VSee;
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

            # Then archive the file in lake/users/

            switch ($chain) {



                case 'vs':
                case 'vs2':
                case 'vsee':

                    $conn = mysqli_connect(
                        'database-1.c5ptxfpwznpr.us-east-1.rds.amazonaws.com',
                        'admin',
                        '4rfvBGT%6yhn',
                        'tms'
                    );

                    $this->info('vsee');

                    # do this after moving files into lake folder

                    if ($chain == 'vs2') { # <------------ this is cron

                        $files = glob('/var/www/data/vs*'); // This is going to include vswh (Webhook)

                    } else {

                        $files = glob('/var/www/lake/vs/*'); // This is to recap everything
                    }

                    $ctr = 0;

                    $sql =
                    "INSERT INTO vsee SET vs_id = %s,
                        user_id = %s,
                        status = %s,
                        subtype = %s,
                        code = %s,
                        first_name = '%s',
                        last_name = '%s',
                        full_name = '%s',
                        username = '%s',
                        vseeid = '%s',
                        dob = '%s',
                        email = '%s',
                        timezone = '%s',
                        accountcode = '%s',
                        token_token = '%s',
                        token_user_type = '%s',
                        rooms = '%s',
                        preference = '%s',
                        token = '%s'
                        ON DUPLICATE KEY UPDATE token_token = '%s', token='%s';";


                    foreach ($files as $file) {

                        if(strpos($file, '@') != false) continue;
                        if(strpos($file, '/vswh') > 0) continue; // don't do the webhooks

                        $ctr++;

                        try {

                            $json = file_get_contents($file);

                            $row = json_decode($json);

                            if (!isset($row->data->vseeid)) {
                                $this->error('No Vsee Id!');
                                continue;
                            }

                            $result = mysqli_query($conn,sprintf($sql,
                                $row->XXX,
                                $row->XXX,
                                $row->XXX,
                                $row->XXX

                            ));

                            $this->line("$ctr. $file");

                            $copy = str_replace('/var/www/data/', '/var/www/lake/vs/', $file);

                            rename($file, $copy);

                        } catch (\Exception $e) {

                            $this->error($e->getMessage() . "\n" . $json . "\n");

                            #exit;

                        }
                    }

                    break;



                case 'bc':
                case 'bc2':
                case 'barcodes':
                case 'barcode':
                    $conn = mysqli_connect(
                        'database-1.c5ptxfpwznpr.us-east-1.rds.amazonaws.com',
                        'admin',
                        '4rfvBGT%6yhn',
                        'tms'
                    );

                    $this->info('barcodes');

                    # do this after moving files into lake folder

                    if ($chain == 'bc2') { # <------------ this is cron

                        $files = glob('/var/www/data/bc*');

                    } else {

                        $files = glob('/var/www/lake/bc/*'); # <-- no, this retries all
                    }

                    $ctr = 0;
# Todo make this a stored procedure or prepared stmt ... but Don't use entities / models for performance
$sql =
"INSERT IGNORE INTO barcodes SET adminsite=%s, patient_id=%s, provider_id=%s, uniq_id = '%s', barcode = '%s', timestamp = '%s'";

                    foreach ($files as $file) { if(strpos($file, '@') != false) continue;

                        $ctr++;

                        try {

                            $json = file_get_contents($file);

                            $row = json_decode($json);

                        if (!isset($row->adminsite)) {
                            continue;
                        }


                        $timestamp = date('Y-m-d H:i:s',filemtime($file));

                            $uniq_id = basename($file);

                            if (!isset($row->provider_id)) {
                                $row->provider_id = 0;
                            }

                            $result = mysqli_query($conn,sprintf($sql,
                                $row->adminsite,
                                $row->patient_id,
                                $row->provider_id,
                                $uniq_id,
                                $row->barcode,
                                $timestamp
                            ));

                            $this->line("$ctr. $file");

                            $copy = str_replace('/var/www/data/', '/var/www/lake/bc/', $file);

                            rename($file, $copy);

                        } catch (\Exception $e) {

                            $this->error($e->getMessage() . "\n" . $json . "\n");

                            #exit;

                        }
                    }

                    break;

                case 'e':
                case 'encounter':
                    $this->info('encounter');

                    $conn = mysqli_connect(
                        'database-1.c5ptxfpwznpr.us-east-1.rds.amazonaws.com',
                        'admin',
                        '4rfvBGT%6yhn',
                        'tms'
                    );

                    # done -1 Make table from barcodes (insert ignore)

                    #1. Get the patient from user table (foreach that not has encounter(s))

                    $sql = "SELECT * FROM users WHERE id > 39 AND ifnull(encounter, 0)=0 and ifnull(dob, '') != ''";

                    $rows = mysqli_query($conn, $sql);

                $sql = "INSERT INTO visits SET
                    visit_id=%s,
                    user_id=%s,
                    member_id=%s,
                    provider_id=%s,
                    account_code='%s',
                    code='%s',
                    start='%s',
                    end='%s',
                    actual_start='%s',
                    actual_end='%s',
                    specialty_id='%s',
                    type=%s,
                    status=%s,
                    completed_by='%s',
                    room_id=%s,
                    room_code='%s',
                    provider_subtype='%s',
                    provider_fullname='%s',
                    provider_title='%s',
                    provider_suffix='%s',
                    provider_email='%s',
                    provider_vsee_id='%s',
                    provider_first_name='%s',
                    provider_last_name='%s',
                    member_full_name='%s',
                    member_email='%s',
                    member_vseeid='%s',
                    member_first_name='%s',
                    member_last_name='%s',
                    payment_description='%s',
                    room_name='%s',
                    room_slug='%s',
                    room_domain='%s' ON DUPLICATE KEY UPDATE
                        start='%s',
                        end='%s',
                        actual_start='%s',
                        actual_end='%s',
                        specialty_id='%s',
                        type=%s,
                        status=%s,
                        completed_by='%s'

                        ";


                try {

                    while ($row = mysqli_fetch_object($rows)) {

                        # Todo Oh God No

                        $name = explode(' ', $row->name . ' Nosurname');

                        $first = $name[0];

                        $last = $name[1];

                        #2. Get their appointments from Vsee

                        $V = new VSee;

                        $visits_json = $V->getVisits($first, $last, $row->dob, $row->email);

                        if (!$visits_json) {
                            $this->error("No Visit for " . $row->name);
                            continue;
                        }

                        $this->info($visits_json);

                        $visits = json_decode($visits_json);

                        # Ignore status 40

                        $user_id = $row->id;

                        foreach ($visits->data as $visit) {

                            if ($visit->status == 40) {
                                $this->line('-- ignoring cancel --');
                                continue;
                            }

                            $this->line("($user_id = $row->id) " . $visit->member->full_name);

                            #2a. Drill down into the visit.  There is more useful data in there.

                            $viz = $V->getVisit($visit->id);

                            $viz = json_decode($viz);

                            $this->line(' sts' . $visit->status . ' viz sys ' . $viz->data->status
                                . ' s ' . date('Y-m-d H:i:s',$viz->data->start) . ' e ' . date('Y-m-d H:i:s',$viz->data->end) . ' as '
                                . date('Y-m-d H:i:s',$viz->data->actual_start) . ' ae ' . date('Y-m-d H:i:s',$viz->data->actual_end));

                            $result = mysqli_query($conn, sprintf($sql,
                                $visit->id,
                                $user_id,
                                $visit->member_id,
                                $visit->provider_id,
                                $visit->account_code,
                                $visit->code,
                                date('Y-m-d H:i:s',$viz->data->start),            #<--- These are the only
                                date('Y-m-d H:i:s',$viz->data->end),              #<--- Useful things we get
                                date('Y-m-d H:i:s',$viz->data->actual_start),     #<--- From pulling the actual
                                date('Y-m-d H:i:s',$viz->data->actual_end),       #<--- Visit data by ID above
                                $visit->specialty_id,
                                $visit->type,
                                $visit->status,
                                $visit->completed_by,
                                $visit->room->id,
                                $visit->room->code,
                                $visit->provider->subtype,
                                mysqli_real_escape_string($conn, $visit->provider->full_name),
                                mysqli_real_escape_string($conn, $visit->provider->title),
                                mysqli_real_escape_string($conn, $visit->provider->suffix),
                                mysqli_real_escape_string($conn, $visit->provider->email),
                                mysqli_real_escape_string($conn, $visit->provider->id),
                                mysqli_real_escape_string($conn, $visit->provider->first_name),
                                mysqli_real_escape_string($conn, $visit->provider->last_name),
                                mysqli_real_escape_string($conn, $visit->member->full_name),
                                mysqli_real_escape_string($conn, $visit->member->email),
                                mysqli_real_escape_string($conn, $visit->member->id),
                                mysqli_real_escape_string($conn, $visit->member->first_name),
                                mysqli_real_escape_string($conn, $visit->member->last_name),
                                mysqli_real_escape_string($conn, $visit->payment->description),
                                mysqli_real_escape_string($conn, $visit->room->name),
                                mysqli_real_escape_string($conn, $visit->room->slug),
                                mysqli_real_escape_string($conn, $visit->room->domain),

                                date('Y-m-d H:i:s',$viz->data->start),            #<--- These are the only
                                date('Y-m-d H:i:s',$viz->data->end),              #<--- Useful things we get
                                date('Y-m-d H:i:s',$viz->data->actual_start),     #<--- From pulling the actual
                                date('Y-m-d H:i:s',$viz->data->actual_end),       #<--- Visit data by ID above
                                $visit->specialty_id,
                                $visit->type,
                                $visit->status,
                                $visit->completed_by));

                            if (!$result) {
                                $this->error($conn->error);
                                exit;
                            }

                        }
                    }
                } catch (\Exception $e) {

                    $this->error($e->getMessage());
                    echo($visits_json);

                }

                #3. Foreach appointment from Vsee
                # find site and provider (ids are in barcodes table)
                # see how we find site id
                # type vaccine right now
                # rendering provider?
                # unique id of encounter (the appointment id from vsee)

                #4. Upsert this shit

                    break;

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

//                            try {

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

                                    $copy = str_replace('/var/www/data/', '/var/www/lake/users/', $file);

                                    rename($file, $copy);

                                }


                                $this->line("$ctr. $file => $id");

//                            } catch (\Exception $e) {
//
//                                $this->error($e->getMessage() . "\n" . $json . "\n" . $i);
//
//                                #exit;
//
//                            }

                        }

                    }

                    break;

                case 'i':
                case 'insurance':

                    # Just get the insurance info from the questionnaire and copy it to temp files for merging into patient_profile

                    # And put a copy in /var/www/erik/public/flags/i/<id> as a temporary way of being able to flag people who
                    # answered Yes on Q6 for the allergy warning

                    # Then archive the file in lake/pq/


                    $this->info('insurance');

                    $files = glob('/var/www/data/pq*');

                    $ctr = 0;

                    foreach ($files as $file) { if(strpos($file, '@') != false) continue;

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

                            $copy = str_replace('/var/www/data/', '/var/www/lake/pq/', $file);

                            rename($file, $copy);


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

                    # so this process is essentially useless

                    # Then archive the file in lake/vswh/


                    $this->info('vsee_webhook');

                    $files = glob('/var/www/data/vswh*');

                    $ctr = 0;

                    foreach ($files as $file) { if(strpos($file, '@') != false) continue;

                        $ctr++;

                        try {

                            $json = file_get_contents($file);

                            $copy = str_replace('/var/www/data/', '/var/www/lake/vswh/', $file);

                            copy($file, $copy);

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
            ->setSsn('0000')
            ->setState($row->state)
            ->setZipcode($row->zipcode)
            ->setId($id);

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
            $insurances = [(object)$a];
            $this->P->setInsurances($insurances);
        }

        $result = $this->P
            ->setPhoneNumbers($phone_numbers)
            ->save();

        return $result;

    }


}
