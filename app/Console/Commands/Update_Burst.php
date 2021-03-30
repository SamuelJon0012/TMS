<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\BurstIq;
use \App\PatientProfile;

class Update_Burst extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_burst';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Looks through Burst changing Race 0 to 8';

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
        $burst = new BurstIq();

        echo "\nChanging race\n";
        $list = $burst->query('patient_profile', "(asset.race = 0)");
        $list = $list->records;
        $len = count($list);
        echo "$len records found\n";

        $patient = new PatientProfile();

        $i = 0;
        foreach($list as $record){
            $i++;
            $asset = $record->asset;
            echo $asset->id.': '.$asset->email . ' ' . $asset->race . "\n";

            if (!isset($asset->date_of_birth)){

                # THIS NEVER HAPPENS

                echo " : No date_of_birth\n";
                continue;
            }

            $oldValue = $asset->race;

            if ($oldValue != 0) {
                continue;
            }

            $patient->setArray([]);
            $patient->make($record);
            $patient->setRace(6);
            #$patient->save();

            echo " : OK ($i of $len)\n";
        }

        echo "\n--- All Done ---\n\n";

        return 0;
    }
}
