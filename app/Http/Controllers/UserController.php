<?php

namespace App\Http\Controllers;

use App\Exports\EmailExport;
use App\Imports\ExcelFile;
use App\Notifications\ConfirmPasswordNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    private $excelType = ['csv', 'xls', 'xlsx'];

    public function __construct()
    {
        $this->middleware("auth");
    }

    public function posTest(Request $request) {
        $user = auth()->user();

        /*if (!$user->hasRole("admin"))
            return response()->json(["error" => "Not have permission"]);
        if (!$request->file("emails"))
            return response()->json(["error" => "Not file"]);
        $emails = explode("\r\n", $request->file("emails")->getContent());
        if (count($emails) === 0)
            return response()->json(["error" => "File is empty"]);*/

        $checkEmails = [];
        $emails = [
            "test@test.com",
            "test1@test.com",
            "drdfy@test.com",
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

    public function createUsersFromEmailList(Request $request) {
        $user = auth()->user();
        if (!$user->hasRole("admin"))
            abort(404);

        if (isset($request->excelFile) && $request->excelFile) {
            $fileType = $request->excelFile->getClientOriginalExtension();
            if (!in_array($fileType, $this->excelType)) {
                return redirect()->home()->with("error", "Wrong file type");
            }

            $validator = Validator::make(
                [
                    'file'      => $request->excelFile,
                    'extension' => strtolower($request->excelFile->getClientOriginalExtension()),
                ],
                [
                    'file'          => 'required',
                    'extension'      => 'required|in:csv,xlsx,xls',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with("error", "The file does not match the csv or xlsx types");
            }

            $user = auth()->user();
            $import = new ExcelFile($user);
            Excel::import($import, request()->file('excelFile'));

            $emails = config('email_export')['data'] ?? [];

            return redirect()->home()->with([
                "excelEmails" => $emails,
                "excelType" => $request->excelFile->getClientOriginalExtension(),
            ]);
        }

/*        if (!isset($request->ec)) {
            $emails = [];
            if ($request->emails && trim($request->emails))
                $emails = explode(",", $request->emails);

            if (count($emails) > 0) {
                foreach ($emails as $email) {

                    if (!trim($email)) continue;

                    $email = trim($email);

                    $validator = Validator::make([$email], [
                        0 => 'email|unique:users,email'
                    ]);

                    if ($validator->fails()) {
                        continue;
                    }

                    $token = Str::random(90);
                    $user = User::create([
                        "email" => $email,
                        "token" => $token,
                        "name" => "User-" . Str::random(5),
                        "password" => "",
                    ]);

                    if (!$user)
                        return response()->json(["error" => "User don't created"]);

                    $data = [
                        "email" => $email,
                        "token" => $token
                    ];

                    $binary = base64_encode(json_encode($data));

                    $user->notify(new ConfirmPasswordNotification($binary));
                }
            }

            return redirect()->route('home');
        } else {
            if (!$request->emails || !trim($request->emails))
                return redirect()->route("home");

            $emails = explode(",", $request->emails);
            if (count($emails) > 0) {
                $csvEmail = [];
                foreach ($emails as $email) {
                    if (!trim($email)) continue;

                    $email = trim($email);
                    $validator = Validator::make([$email], [
                        0 => 'email|unique:users,email'
                    ]);

                    if ($validator->fails())
                        continue;

                    $csvEmail[] = $email;
                }

                if (count($csvEmail) === 0)
                    return redirect()->route("home");

                return $this->array_to_csv_download($csvEmail);
            } else
                return redirect()->route("home");
        }*/

    }

    public function exportEmail(Request $request) {

        if (!$request->emails)
            return redirect()->back();

        if (!$request->type || !in_array($request->type, $this->excelType))
            return redirect()->home()->with("error", "Wrong file type");

        $emails = explode(",", $request->emails);

        $data = [];
        foreach ($emails as $email) {
            $email = trim($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               continue;
            };
            $data[] = $email;
        }

        if (count($data) === 0)
            return redirect()->home()->with("success", "File is empty");

        return Excel::download(new EmailExport($data), "export." . $request->type, ucfirst($request->type));
    }

}
