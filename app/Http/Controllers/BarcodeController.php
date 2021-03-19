<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarcodeController extends Controller
{

    public function __construct() {
        $this->middleware("auth");
    }

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
        $barcode = $request->barcode;

        return view("scan-barcode", compact('userInfo', 'barcode'));
    }

    public function generateBarcodeImage(Request $request) {
        if (!$request->barcode)
            return response()->json(["error" => "The barcode is not"]);

        $user = DB::table("barcodes")->where("barcode", $request->barcode)
            ->join("users", "barcodes.patient_id", "=", "users.id")
            ->select("users.*")->first();

        $bcPatientId = "";
        for ($i = 0; $i < 8 - strlen((string)$user->id); $i++) {
            $bcPatientId .= "0";
        }
        $bcPatientId .= $user->id;

        $bcSiteId = "";
        if ($user->site_id) {
            for ($i = 0; $i < 8 - strlen((string)$user->site_id); $i++) {
                $bcPatientId .= "0";
            }
            $bcSiteId .= $user->site_id;
        } else {
            $bcSiteId = "00000000";
        }
        $bcCustomerId = "00000000";

        $barcodePage = true;
        return view("scan-barcode", compact('barcodePage', 'bcPatientId', 'bcCustomerId', 'bcSiteId'));
    }
}
