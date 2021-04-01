<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sites;
use App\User;
use App\Http\Controllers\Auth\RegisterController;
use App\PatientProfile;

class LabResultsHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!$user = Auth::user())
            abort(401, 'Please login');

        if ($user->hasRole('patient')){
            $P = new PatientProfile();
            if ($P->load($user->id)){
                if ( ($user->hasRole('patient')) && (!$P->getPatientConsented()) )
                    return redirect ("/labResults/covid/{$P->getId()}/".rawurlencode($P->getFirstName().' '.$P->getLastName()));
            }
        }

        if ($user->site_id){
            $site = Sites::where('id',$user->site_id)->first();
            $siteName = $site->name ?? '';
        } else
            $siteName = '';

        $v = $request->get('v');

        $m = $request->get('m');

        $file = '/var/www/tokens/' . $user->id;

        $patientId = str_pad($user->id, 8, '0', STR_PAD_LEFT);
        $customerId = str_pad('0', 8, '0', STR_PAD_LEFT); //TODO: get real Customer ID
        $siteId = str_pad($user->site_id, 8, '0', STR_PAD_LEFT);
        

        if (file_exists($file)) {
            $token = file_get_contents($file);
        } else {
            $token = '0';
        }

        return view('LabResultsHome', ['token' => $token, 'id' => $user->id, 'v' => $v, 'm' => $m,
            'siteId' => $user->site_id, 'siteName' => $siteName, "bcCustomerId" => $customerId,
            "bcSiteId" => $siteId, "bcPatientId" => $patientId]);
    }

    public function showCovid(Request $request)
    {
        return view('covid', ['name' => $request->name, 'id' => $request->id]);
    }

    public function checkCovidTest(Request $request) {
        $P = new PatientProfile();
        $where = "WHERE asset.id=$request->barcode";

        if (!$P->find($where)) {
            return $this->error('Search produced an error');
        }
        if(isset($P->data->records[0])) {
            $data = $P->data->records[0]->asset;

            if(!isset($data->patient_consented) || $data->patient_consented != true) {
                return json_encode([
                    'page'   => "/labResults/covid/{$data->id}/{$data->first_name}%20{$data->last_name}",
                    'action' => "redirect"
                        ]);
            }else {

                return json_encode([
                    'action' => "loadView"
                ], true);

            }
        }


    }

    function newPatient(Request $request){
        if (!$user = Auth::user())
            abort(401, 'Please login');
        if (!$user->checkRole('provider'))
            abort(403, 'You can not access to register a patient');

        return view('auth.labResultsRegister',['isProvider'=>true]);
    }

    function registerNewPatient(Request $request){
        if (!$user = Auth::user())
            abort(401, 'Please login');
        if (!$user->checkRole('provider'))
            abort(403, 'You can not access to register a patient');

        $con = new RegisterController();
        $patient = $con->RegisterPatient($request->all());
        return redirect('/home')->with('newPatientId',$patient->id);
    }

    public function setResults($id, $name) {
        $encounter = new \App\Encounter();
        $encounter_data = $encounter->find("where asset.patient_id = {$id}")->getData();
        $procedures = [];
        if(count($encounter_data->records) > 0)
        {
            for($i =0; $i < count($encounter_data->records); $i++)
            {
                if(isset($encounter_data->records[$i]->asset->procedures) && count($encounter_data->records[$i]->asset->procedures) > 0)
                {
                    for($ii = 0; $ii < count($encounter_data->records[$i]->asset->procedures); $ii++)
                    {
                        $datevar = '$date';

                        // check if the procedure does not have a result
                        $procedureResult = new \App\ProcedureResults();
                        $thisProcedureResults = $procedureResult->find("where asset.patient_id = {$id} and asset.encounter_id = {$encounter_data->records[$i]->asset->id} and asset.procedure_id = {$encounter_data->records[$i]->asset->procedures[$ii]->id}");

                        if(isset($thisProcedureResults->data->records[0]->asset) && $thisProcedureResults->data->records[0]->asset->result != "")
                        {
                            continue;
                        }

                        $procedures[] = [
                            'patient_id' => $id,
                            'encounter_id' => $encounter_data->records[$i]->asset->id,
                            'procedure' => $encounter_data->records[$i]->asset->procedures[$ii],
                            'datetime' => $encounter_data->records[$i]->asset->datetime->$datevar
                            ];

                    }
                }
            }
        }

        $result = [
          'name' => $name,
          'procedures' => $procedures
        ];
        return view('set-results', compact('result'));
    }


    public function setResultsSave($id, $name) {

        $procedureResults = new \App\ProcedureResults();

        $procedureResults->setPatientId($_POST['patient_id']);
        $procedureResults->setEncounterId($_POST['encounter_id']);
        $procedureResults->setProcedureId($_POST['procedure_id']);
        $procedureResults->setResult($_POST['result']);
        $procedureResults->setDatetime(date("Y-m-d\TH:i:s.000\Z"));
        $procedureResults->setExpirationDatetime(date("Y-m-d\TH:i:s.000\Z", strtotime("+4 Days")));

        $result = $procedureResults->save();


        // flash here..

        return redirect('/home');



    }

}
