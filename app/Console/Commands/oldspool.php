<?php

namespace App\Console\Commands;

use App\Encounter;
use App\PatientProfile;
use App\User;
use App\VSee;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\OutputInterface;

class spool extends Command
{

    protected $P;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:oldspool {chain}';

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

        $this->output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);

        $chain = $this->argument('chain');


        //try {

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

                # NOT DONE YET ! ! !

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

                        #rename($file, $copy);

                    } catch (\Exception $e) {

                        $this->error($e->getMessage() . "\n" . $json . "\n");

                        #exit;

                    }
                }

                break;

            case 'fix':

                $conn = mysqli_connect(
                    'database-1.c5ptxfpwznpr.us-east-1.rds.amazonaws.com',
                    'admin',
                    '4rfvBGT%6yhn',
                    'tms'
                );
                $sql = 'CALL $barcode_fixer()';

                mysqli_query($conn, $sql);

                break;

            case 'er': // encounter realtime

                $conn = mysqli_connect(
                    'database-1.c5ptxfpwznpr.us-east-1.rds.amazonaws.com',
                    'admin',
                    '4rfvBGT%6yhn',
                    'tms'
                );

                $sql = 'select * from barcodes where fixed=1 and encountered=0';

                $enc_sql = "select
                    b.id,
                    u.id as patient_id,
                    b.site_id as site_id,
                    b.site_id as room_code,
                    b.provider_id as provider_id,
                    b.`timestamp` as `datetime`,
                    1 as `type`,
                    1 as question_1_id,
                    'No' as question_1_answer,
                    2 as question_2_id,
                    'No' as question_2_answer,
                    3 as question_3_id,
                    'No' as question_3_answer,
                    4 as question_4_id,
                    'No' as question_4_answer,
                    5 as question_5_id,
                    'No' as question_5_answer,
                    6 as question_6_id,
                    'No' as question_6_answer,
                    0 as billing_provider_id,
                    1 as proc_1_id,
                    b.provider_id as proc_1_rpid,
                    d.labeler_name as vendor,
                    d.manufacturer_id as manufacturer,
                    b.lot as lot_number,
                    1 as dose_number,
                    b.timestamp as dose_date,
                    d.strength as size,
                    b.barcode,
                    s.name as room_name
                    from barcodes b
                    join users u on b.patient_id = u.id
                    left join users p on p.id = b.provider_id
                    left join sites s on s.id = b.site_id
                    left join drugs d on d.ndc_product_code = b.ndc
                    where b.id = %s";

                $ok_sql = 'UPDATE barcodes SET encountered = 1 WHERE id = %s';

                $rows = mysqli_query($conn, $sql);

                if ($rows) {

                    $P = new Encounter();

                    # There is some hard coded stuff in this query like manufacturer etc that will need to be corrected

                    while ($row = mysqli_fetch_object($rows)) {

                        $eds = mysqli_query($conn, sprintf($enc_sql, $row->id));

                        if (!$eds) {

                            $this->error("Error description: " . mysqli_error($conn));

                            exit;

                            continue;

                        }

                        while ($ed = mysqli_fetch_object($eds)) {

                            $biqResponse = $this->upsertEncounter($P, $ed);

                            // Todo check for ok

                            $done = mysqli_query($conn, sprintf($ok_sql, $row->id));

                            var_dump($biqResponse); // ... 200 / The operation was successful

                            var_dump($done); // true

                            #exit;
                        };

                    }

                } else { $this->line('Nothing to do'); }

                break;

            case 'bc':
            case 'bc2':
            case 'barcodes':
            case 'barcode':


                // Insert barcodes into the barcode table where they will be fixed with 'fix'

                $conn = mysqli_connect(
                    'database-1.c5ptxfpwznpr.us-east-1.rds.amazonaws.com',
                    'admin',
                    '4rfvBGT%6yhn',
                    'tms'
                );

                $this->info('barcodes');

                if ($chain == 'bc2') { # <------------ this is cron

                    $files = glob('/var/www/data/bc*');

                } else {

                    $this->error('Use bc2 instead');

                    exit;

                    $files = glob('/var/www/lake/bc/*'); # <-- no, this retries all
                }

                $ctr = 0;
# Todo make this a stored procedure or prepared stmt ... but Don't use entities / models for performance
                $sql =
                    "INSERT INTO barcodes
                    SET site_id=%s,
                        adminsite=%s,
                        patient_id=%s,
                        provider_id=%s,
                        uniq_id = '%s',
                        barcode = '%s',
                        timestamp = '%s'
                    ON DUPLICATE KEY UPDATE encountered=0, site_id=%s";

                foreach ($files as $file) { if(strpos($file, '@') != false) continue;

                    $ctr++;

                    try {

                        $json = file_get_contents($file);

                        $row = json_decode($json);

                        if (!isset($row->adminsite)) {
                            continue;
                        }

                        if (isset($row->timestamp)) {

                            $timestamp = strtotime($row->timestamp);

                        } else {

                            $timestamp = date('Y-m-d H:i:s', filemtime($file));

                        }

                        $uniq_id = basename($file);

                        if (!isset($row->provider_id)) {
                            $row->provider_id = 0;
                        }

                        if (isset($row->site_id)) {

                            // Only insert if we have a site ID
                            //
                            // Todo: This was temporary in order to load site_ids to existing

                            $result = mysqli_query($conn,sprintf($sql,
                                $row->site_id,
                                $row->adminsite,
                                $row->patient_id,
                                $row->provider_id,
                                $uniq_id,
                                $row->barcode,
                                $timestamp,
                                $row->site_id
                            ));

                            if (!$result) {

                                $this->error("Error description: " . mysqli_error($conn));

                                exit;

                        }

                        }


                        $this->line("$ctr. $file");

                        if ($chain == 'bc2') { # <------------ this is cron

                            $copy = str_replace('/var/www/data/', '/var/www/lake/bc/', $file);

                            $this->line("copy $file to $copy");

                            rename($file, $copy);
                        }

                    } catch (\Exception $e) {

                        $this->error($e->getMessage() . "\n" . $json . "\n");

                        #exit;

                    }
                }

                break;

            case 'e': # No, this is not encounters, this just updates the Visits table which we do not neet
            case 'encounter':
                $OLD = '';
                $this->info('encounter');

                //$filename = '/var/www/lake/' . uniqid(true) . '.sql';

                //file_put_contents($filename,'');

                $conn = mysqli_connect(
                    'database-1.c5ptxfpwznpr.us-east-1.rds.amazonaws.com',
                    'admin',
                    '4rfvBGT%6yhn',
                    'tms'
                );

                # done -1 Make table from barcodes (insert ignore)

                #1. Get the patient from user table (foreach that not has encounter(s)) MEMEME

                #$sql = "SELECT * FROM users WHERE id > 39 AND ifnull(encounter, 0)=0 and ifnull(dob, '') != ''";

                # refresh everyone
                $sql = "SELECT u.* FROM users u LEFT JOIN visits v ON v.user_id = u.id WHERE v.id IS NULL and u.id > 39 and ifnull(u.dob, '') != ''";

                #The Robert Higginses (no Visit found)
                #$sql = "SELECT * FROM users WHERE id > 39 AND ifnull(encounter, 0)=0 and ifnull(dob, '') != '' and id in (2515,2512)";

                #$sql = "SELECT * FROM users WHERE id > 39 AND ifnull(dob, '') != ''";
                # Todo: Update visits with open status (10, 20) close visits with barcodes

                $rows = mysqli_query($conn, $sql);

                $sql = "INSERT INTO visits SET
                    visit_id='%s',
                    user_id='%s',
                    member_id='%s',
                    provider_id='%s',
                    account_code='%s',
                    code='%s',
                    start='%s',
                    end='%s',
                    actual_start='%s',
                    actual_end='%s',
                    specialty_id='%s',
                    type='%s',
                    status='%s',
                    completed_by='%s',
                    room_id='%s',
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
                        type='%s',
                        status='%s',
                        completed_by='%s'

                        ";


                try {
                    $V = new VSee;

                    while ($row = mysqli_fetch_object($rows)) {

                        try {

                            # Todo Oh God No

                            $name = explode(' ', $row->name . ' Nosurname');

                            $first = $name[0];

                            $last = $name[1];

                            #2. Get their appointments from Vsee

                            $visits_json = $V->getVisits($first, $last, $row->dob, $row->email);

                            if (!$visits_json) {
                                $this->error("No Visit for " . $row->name);
                                continue;
                            }

                            $this->info($visits_json);

                            $visits = json_decode($visits_json);

                            # Ignore status 40

                            $user_id = $row->id;

                            $lastvisit = false;

                            foreach ($visits->data ?? false as $visit) {

                                if (!$visit) {
                                    $this->error("DATA missing");
                                    continue;
                                }

                                if ($visit->status == 40) {
                                    $this->line('-- ignoring cancel --');
                                    continue;
                                }
                                $lastvisit = $visit;
                                $this->line('lastvisit...');
                            }
                            if (!empty($lastvisit)) {
                                $this->line("($user_id = $row->id) " . $visit->member->full_name);

                                #2a. Drill down into the visit.  There is more useful data in there.

                                $viz = $V->getVisit($visit->id);

                                $viz = json_decode($viz);

                                $this->line(' sts' . $visit->status . ' viz sys ' . $viz->data->status
                                    . ' s ' . date('Y-m-d H:i:s',$viz->data->start) . ' e ' . date('Y-m-d H:i:s',$viz->data->end) . ' as '
                                    . date('Y-m-d H:i:s',$viz->data->actual_start) . ' ae ' . date('Y-m-d H:i:s',$viz->data->actual_end));

                                $this->line('INSERTING VISIT');

                                $SQL = sprintf($sql,
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
                                    $visit->room->id ?? '',
                                    $visit->room->code ?? '',
                                    $visit->provider->subtype ?? '',
                                    mysqli_real_escape_string($conn, $visit->provider->full_name ?? ''),
                                    mysqli_real_escape_string($conn, $visit->provider->title ?? ''),
                                    mysqli_real_escape_string($conn, $visit->provider->suffix ?? ''),
                                    mysqli_real_escape_string($conn, $visit->provider->email ?? ''),
                                    mysqli_real_escape_string($conn, $visit->provider->id ?? ''),
                                    mysqli_real_escape_string($conn, $visit->provider->first_name ?? ''),
                                    mysqli_real_escape_string($conn, $visit->provider->last_name ?? ''),
                                    mysqli_real_escape_string($conn, $visit->member->full_name ?? ''),
                                    mysqli_real_escape_string($conn, $visit->member->email ?? ''),
                                    mysqli_real_escape_string($conn, $visit->member->id ?? ''),
                                    mysqli_real_escape_string($conn, $visit->member->first_name ?? ''),
                                    mysqli_real_escape_string($conn, $visit->member->last_name ?? ''),
                                    mysqli_real_escape_string($conn, $visit->payment->description ?? ''),
                                    mysqli_real_escape_string($conn, $visit->room->name ?? ''),
                                    mysqli_real_escape_string($conn, $visit->room->slug ?? ''),
                                    mysqli_real_escape_string($conn, $visit->room->domain ?? ''),

                                    date('Y-m-d H:i:s',$viz->data->start),            #<--- These are the only
                                    date('Y-m-d H:i:s',$viz->data->end),              #<--- Useful things we get
                                    date('Y-m-d H:i:s',$viz->data->actual_start),     #<--- From pulling the actual
                                    date('Y-m-d H:i:s',$viz->data->actual_end),       #<--- Visit data by ID above
                                    $visit->specialty_id,
                                    $visit->type,
                                    $visit->status,
                                    $visit->completed_by);
                                if ($SQL != $OLD) {
                                    $result = mysqli_query($conn, $SQL);
                                    $OLD = $SQL;
                                }

                                if (!$result) {
                                    $this->error($conn->error);

                                }
                                # WTF????
                                #mysqli_query($conn, "
                                #    update users u
                                #    left join visits v on v.user_id = u.id
                                #    set u.encounter=v.status
                                #");

                            }
                        } catch (\Exception $e) {
                            $this->error('Inner: ' . $e->getMessage());
                        }
                    }
                } catch (\Exception $e) {

                    $this->error($e->getMessage());
                    echo($visits_json);
                    echo($SQL ?? '');

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
                #$files = glob('/var/www/lake/users/*');

                $ctr = 0;

                foreach ($files as $file) {

                    if (strpos($file, '@')) {

                        //if ($file == '/var/www/data/cmcochran@cbsd.org') {

                        $ctr++;

                        try {

                            $i = '!!!!!!!!!!!';

                            $json = file_get_contents($file);

                            $row = json_decode($json);

                            $dob = $row->date_of_birth;

                            $dob = str_replace('2021-', '1970-', $dob);

                            if (strpos($dob, '/') > 0) {

                                // Todo - try to correct the date here
                                $dob = '1970-01-01';


                            }
                            if (strpos($dob, '-') == 5) {
                                $dob = '2000-01-01';
                            };
                            if (empty($dob)) {
                                $dob = '1980-01-01';
                            }
                            $row->date_of_birth = $dob;

                            $row->phone_number = $row->phone_number ?? '1111111111';

                            $em = $row->email;

                            $user = User::where('email', $em)->first();

                            $id = $user->id;

                            $this->line("HAY!!!!! $em is $id");

                            #if ($id != 510) continue;

                            file_put_contents("work/pp/$id", $json);

                            if (file_exists("work/i/$id")) {

                                // we can process this patient because an i exists and fo

                                $i = file_get_contents("work/i/$id");

                                $result = $this->upsertPatient($id, $row, json_decode($i));

                                $copy = str_replace('/var/www/data/', '/var/www/lake/users/', $file);

                                $this->line("Move $file to $copy");

                                rename($file, $copy);

                            } else {

                                $this->line('*** No questionnaire file yet');

                                // qmake it, then it'll get picked up next time Todo

                                $json = '{"user_id":"%s","_token":"lCxiYEUBdClmKU5ciBlydAbL6f0ebbjHoHuHnIgv","q1":"No","q2":"No","q3":"No","q4":"No","q5":"No","q6":"No","have_insurance":"No","administrator_name":"","plan_type":"","plan_id":"","employer_name":"","group_id":"","coverage_effective_date":"","primary_cardholder":"","issuer_id":"","insurance_type":"","relationship_to_primary_cardholder":""}';

                                $fn = "/var/www/erik/work/i/$id";

                                $json = sprintf($json, $id);

                                if (file_Exists($fn)) {
                                    exit("\nFile already exists\n");
                                }

                                file_put_contents($fn, $json);

                                chmod($fn, 0777);



                            }


                            $this->line("$ctr. $file => $id");

                        } catch (\Exception $e) {

                            $this->error($e->getMessage() . "\n" . $json . "\n" . $i);

                            #exit;

                        }

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

                        $this->line("rename $file as $copy");

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


//        } catch
//        (\Exception $e) {
//
//            $this->error($e->getMessage());
//        }


        return 0;
    }



    function upsertPatient($id, $row, $i)
    {

        $this->P->setAddress1($row->address1) // errors out here when it's a provider ... meh that's fine
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
    function upsertEncounter($P, $row) {

        $patient_questions = [
            [ 'question_id' => $row->question_1_id, 'patient_response' => $row->question_1_answer ],
            [ 'question_id' => $row->question_2_id, 'patient_response' => $row->question_2_answer ],
            [ 'question_id' => $row->question_3_id, 'patient_response' => $row->question_3_answer ],
            [ 'question_id' => $row->question_4_id, 'patient_response' => $row->question_4_answer ],
            [ 'question_id' => $row->question_5_id, 'patient_response' => $row->question_5_answer ],
            [ 'question_id' => $row->question_6_id, 'patient_response' => $row->question_6_answer ]
        ];
        $procedures = [
            'id' => $row->proc_1_id,
            'rendering_provider_id' => $row->proc_1_rpid,
            'vendor' => $row->vendor,
            'manufacturer' => $row->manufacturer,
            'lot_number' => $row->lot_number,
            'dose_number' => $row->dose_number,
            'dose_date' => $row->dose_date,
            'size' => $row->size
        ];


        $result = $P->setId($row->id)
            ->setPatientId($row->patient_id)
            ->setProviderId($row->provider_id)
            ->setSiteId($row->site_id)
            ->setDateTime($row->datetime)
            ->setType($row->type)
            ->setPatientQuestionResponses($patient_questions)
            ->setProcedures($procedures)

            ->save();

        return $result;

    }

}
