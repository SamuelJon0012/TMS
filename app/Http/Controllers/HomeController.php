<?php

namespace App\Http\Controllers;
use LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sites;
use App\Http\Controllers\Auth\RegisterController;

class HomeController extends Controller
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

        if ($user->site_id){
            $site = Sites::where('id',$user->site_id)->first();
            $siteName = $site->name ?? '';
        } else
            $siteName = '';

        $v = $request->get('v');

        $m = $request->get('m');

        $file = '/var/www/tokens/' . $user->id;

        $countZero = 8 - strlen((string) $user->id);
        $patientId = "";

        if ($countZero > 0)
            for ($i = 0; $i < $countZero; $i++)
                $patientId .= "0";

        $patientId .= $user->id;

        $countZero = 8 - strlen((string) $user->site_id);
        $siteId = "";

        if ($countZero > 0)
            for ($i = 0; $i < $countZero; $i++)
                $siteId .= "0";

        $siteId .= $user->site_id;

        $customerId = "";

        for ($i = 0; $i < 8; $i++)
            $customerId .= "0";


        if (file_exists($file)) {
            $token = file_get_contents($file);
        } else {
            $token = '0';
        }
            return view('home', ['token' => $token, 'id' => $user->id, 'v' => $v, 'm' => $m,
                'siteId' => $user->site_id, 'siteName' => $siteName, "bcCustomerId" => $customerId,
                "bcSiteId" => $siteId, "bcPatientId" => $patientId]);
    }

    function newPatient(Request $request){
        if (!$user = Auth::user())
            abort(401, 'Please login');
        if (!$user->checkRole('provider'))
            abort(403, 'You can not access to register a patient');

        return view('auth.register',['isProvider'=>true]);
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

}
