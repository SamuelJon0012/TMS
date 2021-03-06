<?php

namespace App\Http\Controllers;

use App\PatientProfile;
use App\User;
use App\VSee;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VSeeController extends Controller
{
    //



    function test() {

        $V = new VSee();

//        $name = explode(' ', Auth::user()->name . ' Nosurname');
//
//        $first = $name[0];
//        $last = $name[1];
//
//        $dob = Auth::user()->dob;
//        $email = Auth::user()->email;

        $first = 'Joe';
        $last = 'Test';
        $dob = '2000-01-01';
        $email = 'joe@moo.cow';

        $result = $V->getSSOToken($first, $last, $dob, $email);

        $token = $result->data->token->token;

        $url = "https://trackmysolutions.vsee.me/auth?sso_token=$token&next=/";

        return redirect($url);



    }
    function redirect()
    {

        // Save questionnaire and return vsee.redirect view which redirects the person to Vsee

        //$B = new BurstIq();

        $data = json_encode($_POST);

        // Spool pq = patient questionnaire, vs = vsee

        if ($data != '[]') {

            file_put_contents('/var/www/data/pq' . uniqid(true), $data);

        }

        if (!$user = Auth::user())
            abort(401, 'Please login');

        list($first, $last) = $user->getFirstAndLastNames();

        $dob = Auth::user()->dob;

        $email = Auth::user()->email;

        $id = Auth::id();

        $file = '/var/www/tokens/' . $id;

        $V = new VSee();

        $result = $V->getSSOToken($first, $last, $dob, $email);

        if (isset($result->data->token->token)) {

            $token = $result->data->token->token;

        } else {

            if (isset($result->message)) {

                return redirect('/home?v=1&m=(token)' . $result->message);

            } else {

                return redirect('/home?v=1');

            }


        }

        $id = $result->data->id;

        if (!file_exists($file)) {

            file_put_contents($file, $id);

        }

	$slug = Auth::user()->slug;

	if (empty($slug)) {

        $url = "https://trackmysolutions.vsee.me/auth?sso_token=$token&next=/";

	} else {

        $url = "https://trackmysolutions.vsee.me/auth?sso_token=$token&next=/u/$slug";

	}

        return redirect($url);

    }

    function return()
    {

        try {

            # Todo Oh God No

            $name = explode(' ', Auth::user()->name . ' Nosurname');

        } catch (\Exception $e) {

            $E = [];

            $E['spot'] = 'VSC2';
            $E['error'] = $e->getMessage();
            $E['user'] = Auth::id();
            file_put_contents('/var/www/errors/er' . uniqid(true), json_encode($E));

            return redirect('/home?v=1');
        }

        $first = $name[0];

        $last = $name[1];

        $dob = Auth::user()->dob;

        $email = Auth::user()->email;

        $id = Auth::id();

        $file = '/var/www/tokens/' . $id;

        $V = new VSee();

        $result = $V->getSSOToken($first, $last, $dob, $email);

        if (isset($result->data->token->token)) {

            $token = $result->data->token->token;

        } else {

            if (isset($result->message)) {

                return redirect('/home?v=1&m=' . $result->message);

            } else {

                return redirect('/home?v=1');

            }

        }

        $id = $result->data->id;

        if (!file_exists($file)) {

            file_put_contents($file, $id);

        }





	$slug = Auth::user()->slug;


	if (empty($slug)) {

        $url = "https://trackmysolutions.vsee.me/auth?sso_token=$token&next=/";

	} else {

        $url = "https://trackmysolutions.vsee.me/auth?sso_token=$token&next=/u/$slug";

	}



        return redirect($url);

    }


    function webhook(Request $request)
    {

        //$B = new BurstIq();

        $data = json_encode($request->getContent());

        // Spool pq = patient questionnaire, vs = vsee

        file_put_contents ('/var/www/data/vswh' . uniqid(true), $data);

        return response('OK', 200)
            ->header('Content-Type', 'text/plain');


    }
    function loginAs(Request $request) {

        $u = $request->get('u');

        if (is_numeric($u)) {

            $user = User::where('id', $u)->first();

        }else {

            $user = User::where('email', $u)->first();

        }

        $id = $user->id;

        Auth::loginUsingId($id);

        return redirect('/home');

        var_dump($user);exit;

        Auth::loginUsingId(1);
    }

    function visits() {

        $V = new VSee;

        $result = $V->getVisits();



    }
    function saveonly(Request $request) // Update the patient but do not SSL
    {

        // Save questionnaire and redirect to home (saved by provider)

        $data = json_encode($_POST);

        # Save a copy of what was entered

        file_put_contents ('/var/www/data/prq' . uniqid(true), $data);

        # Yes this part is still stupid --------------

        /* What this does is put a file on the disk that can be detected with ajax on the barcode page and if detected
           it displays the allergy warning.  This was the only way I could think of the ad this feature in the 10 seconds
           of alloted dev time */

        $q6 = $request->get('q6');

        $q_patient_id = $request->get('q_patient_id');

        if (!empty($q_patient_id)) {

            $file = 'flags/q6/' . $q_patient_id;

            if ($q6 == 'Yes') {
                file_put_contents($file, $data);
            }
            if ($q6 == 'No') {
                if (file_exists($file)) {

                    unlink($file);

                }
            }

        }

        # End of Stupid ----------------------

        // Todo: Error trap this

        $P = new PatientProfile();

        $P->query('patient_profile', 'WHERE asset.id=' . $q_patient_id);

        $records = $P->data->records; // Make $P->data public

	return redirect('/home');

        foreach ($records as $record) {

            // There should only be 1 match here so this is more like first()

            $P->make($record);


            $insurances = [[

                "administrator_name" => $request->get('administrator_name'),
                "group_id" =>$request->get('administrator_name'),
                "employer_name" =>$request->get('administrator_name'),
                "coverage_effective_date" =>$request->get('administrator_name'),
                "issuer_id" =>$request->get('administrator_name'),
                "primary_cardholder" =>$request->get('administrator_name'). " " . $request->get('administrator_name'),
                "insurance_type" => $request->get('administrator_name'),
                "relationship_to_primary_cardholder" => $request->get('administrator_name'),
                "plan_type" => $request->get('administrator_name'),
                "plan_id" => $request->get('administrator_name'),

            ]];


            $result = $P->setInsurances($insurances) ->save();

            break;

        }



        return redirect('/home');

    }

    /**
     * Temp function to establish how to mark a visit as complete
     */
    function test_completing_a_visits(){
        $first = 'Kyle';
        $last = 'Peterman';
        $dob = '1974/04/10';
        $email = 'kpetey123@gmail.com';

        //Get visits
        $vsee = new VSee();
        $visits = $vsee->getVisits($first, $last, $dob, $email);

        if (($visits) and ($visits = json_decode($visits))) {

            dd($visits);

            $visit_id = 14518275;
            $member_id = 13963264;
            $provider_id = 14142453;
/*
            if ($err = $vsee->startVisit($visit_id))
                die('VSee->startVisitVisit returned '.$err);
*/            

            //switch to provider
            $vseeAdmin = new VSee();
            //$token = $vseeAdmin->getSSOToken('Leeney','Sweeney','','leeney.sweeney@gmail.com', $vsee::USERTYPE_PROVIDER);
            $token = $vseeAdmin->getSSOToken('Test','Test','','anton+Testing1@vsee.com', $vsee::USERTYPE_PROVIDER); //make up a new someone
            
            //exit('<pre>'.json_encode($token, JSON_PRETTY_PRINT).'</pre>');
            $provider_id = $token->data->id;
            $token = $token->data->token->token;
            


            //if ($err = $vseeAdmin->closeVisit($visit_id, ['completed_by'=>$provider_id, 'provider_id'=>$provider_id], $token) )
            if ( $err = $vseeAdmin->closeVisit($visit_id, null, []) )
                die('VSee->closeVisit returned '.$err);
            else
                die('OK');

            /*
            if ($err = $vsee->deleteVisit($visit_id))
                die('VSee->deleteVisit returned '.$err);
            else
                die('OK');
            */

        }
    }


}
