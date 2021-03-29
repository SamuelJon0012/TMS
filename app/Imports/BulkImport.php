<?php

namespace App\Imports;

use App\Notifications\ConfirmPasswordNotification;
use App\PatientProfile;
use App\Services\BurstIqService;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BulkImport implements ToCollection, WithHeadingRow, SkipsOnError, SkipsOnFailure
{

    use SkipsErrors;
    use SkipsFailures;
    /** @var User */
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection($rows) {
        $token = false;
        if (count($rows) > 0)  {
            foreach ($rows as $row) {
                if (!isset($row["email"])) break;

                $email = trim($row["email"]);
                $validator = Validator::make([$email], [
                    0 => "required|unique:users,email"
                ]);

                if ($validator->fails())
                    continue;

                $data = [];
                foreach ($row as $k => $r) {
                    $data[$k] = (gettype($r) === "string") ? trim($r): $r;
                }
                $token = Str::random(90);
                $user = User::create([
                    "name" =>  $row["first_name"] . " " . $row["last_name"],
                    "email" => $email,
                    "token" => $token,
                    "password" => Hash::make(uniqid()),
                    "json" => json_encode($data),
                    "dob" => date('Y/m/d',strtotime($row["date_of_birth"])),
                    "phone" => $row["phone_number"],
                ]);

                $data['id'] = $user->id;

                $binary = base64_encode(json_encode([
                    "email" => $row["email"],
                    "token" => $token
                ]));

                $user->notify(new ConfirmPasswordNotification($binary));

                BurstIqService::getInstance()->createPatientProfile($data);
            }
        }

        return $token;
    }
}
