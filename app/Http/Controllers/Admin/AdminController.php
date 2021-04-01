<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\BulkImport;
use App\PatientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function __construct()
    {
    }

    public function index() {
        return view("vendor.admin.dashboard");
    }

    public function bulkImport() {
        return view("vendor.admin.bulk-import");
    }

    public function getCreateUsersFromExcel(Request $request) {
        return redirect()->back();
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
