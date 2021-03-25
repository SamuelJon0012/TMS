<?php

namespace App\Http\Controllers;

use App\Imports\BulkImport;
use App\Notifications\ConfirmPasswordNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    public function __construct()
    {
//        $this->middleware("auth");
    }

    public function createPatient(Request $request) {
        $emails = [
            Str::random(8) . "@" . Str::random(4) . "." . Str::random(3),
        ];
        foreach ($emails as $email) {
            $validator = Validator::make([$email], [
                0 => 'email|unique:users,email'
            ]);

            if ($validator->fails())
                continue;

            $token = Str::random(90);
            $user = User::create([
                "email" => $email,
                "token" => $token,
                "name" =>  "User-" . Str::random(5),
                "password" => "",
            ]);

            if (!$user)
                return response()->json(["error" => "User don't created"]);
            DB::table('role_user')->insert(['user_id' => $user->id,'role_id' => 2,'created_at' => now(),'updated_at' => now()]);

            $data = [
                "email" => $email,
                "token" => $token
            ];

            $binary = base64_encode(json_encode($data));

            $user->notify(new ConfirmPasswordNotification($binary));
        }
    }

    public function geTest() {
        $user = auth()->user();

        if (!$user->hasRole("admin"))
            return response()->json(["error" => "Not have permission"]);
        return view("test");
    }

    public function activateUser($token) {
        $json = base64_decode($token);
        $userData = json_decode($json, true);
        if (!$userData || (!isset($userData["email"]) && !isset($userData["token"]))) {
            abort(404);
        }

        $user = User::where([
            "email" => $userData["email"],
            "token" => $userData["token"]
        ])->first();

        if (!$user) {
            abort(404);
        }

        return view("auth.passwords.create-password", compact("user"));
    }

    public function createPassword($token, Request $request) {
        $json = base64_decode($token);
        $userData = json_decode($json, true);
        if (!$userData || (!isset($userData["email"]) && !isset($userData["token"]))) {
            abort(404);
        }

        $user = User::where([
            "email" => $userData["email"],
            "token" => $userData["token"]
        ])->first();

        if (!$user) {
            abort(404);
        }

        $request->validate([
            "password" => "required|confirmed|min:8|string"
        ]);

        $user->password = Hash::make($request->password);
        $user->token = null;
        $user->save();

        Auth::login($user);

        return redirect()->home();
    }

    public function createUsersFromExcel(Request $request) {

        $user = auth()->user();

        if (!$user->hasRole("admin"))
            return abort(404);

        $validator = Validator::make(
            [
                'excelFile'      => $request->excelFile,
                'extension' => strtolower($request->excelFile->getClientOriginalExtension()),
            ],
            [
                'excelFile'          => 'required',
                'extension'      => 'required|in:csv,xlsx,xls',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("error", "Inappropriate file type");
        }

        $import = new BulkImport($user);

        Excel::import($import, $request->file("excelFile"));

        return redirect()->back()->with("successImport", "Users added");
    }
}
