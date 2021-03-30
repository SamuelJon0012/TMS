<?php

namespace App\Console\Commands;

use App\barcodes;
use Illuminate\Console\Command;

class welcome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:welcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send out welcome letters';

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

        #$emails = users where is_welcomed = 0

        return 0;
    }
}
