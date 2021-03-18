<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarcodeController extends Controller
{
    public function scan() {
        return view("scan-barcode");
    }

    public function getUserInformation(Request $request) {
        if (!$request->barcode)
            return abort(404);

        $user = DB::table("barcodes")->where("barcode", $request->barcode)
            ->join("users", "barcodes.patient_id", "=", "users.id")
            ->select("users.*")->first();

        if (!$user)
            return abort(404);

        $userInfo = json_decode($user->json);

        return view("scan-barcode", compact('userInfo'));
    }
}
