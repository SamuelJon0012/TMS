<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function changeConfirmed(Request $request){
        $userId = $request['user_id'];
        $patient = User::find($userId);
        $patient->is_confirmed = 1;
        $patient->save();
        return redirect()->back();
    }
}
