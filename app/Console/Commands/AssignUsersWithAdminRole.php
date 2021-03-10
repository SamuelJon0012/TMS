<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Models\Role;

class AssignUsersWithAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:admin-role';

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
        $users = User::where('id','<',40)->orWhere('email','LIKE','%trackmysolutions%')->get();
        foreach($users as $user){
            $roleUserAdmin = DB::table('role_user')->where('user_id',$user->id)->where('role_id',1)->first();
            if(!$roleUserAdmin){
                DB::table('role_user')->insert(['user_id' => $user->id,'role_id' => 1,'created_at' => now(),'updated_at' => now()]);
            }
        }
    }
}
