<?php

namespace App\Console\Commands;

use App\Jobs\SendRegistrationMailJob;
use App\User;
use Illuminate\Console\Command;

class SendRegistrationMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:registration-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       $users = User::patients()->selectRaw('users.id AS id')->where('is_welcomed',0)->get();
       foreach($users as $user){
           dispatch(new SendRegistrationMailJob($user));
       }
    }
}
