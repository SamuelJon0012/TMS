<?php

namespace App\Http\Controllers;

use App\VSee;
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

        file_put_contents ('/var/www/data/pq' . uniqid(true), $data);

        $name = explode(' ', Auth::user()->name . ' Nosurname');

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

            return redirect('/home?v=1');

        }

        $id = $result->data->id;

        if (!file_exists($file)) {

            file_put_contents($file, $id);

        }

        $url = "https://trackmysolutions.vsee.me/auth?sso_token=$token&next=/";

        return redirect($url);

    }

    function return()
    {

        // Save questionnaire and return vsee.redirect view which redirects the person to Vsee

        //$B = new BurstIq();

        $data = json_encode($_POST);

        // Spool pq = patient questionnaire, vs = vsee

        file_put_contents ('/var/www/data/pq' . uniqid(true), $data);

        $name = explode(' ', Auth::user()->name . ' Nosurname');

        $first = $name[0];

        $last = $name[1];

        $dob = Auth::user()->dob;

        $email = Auth::user()->email;

        $id = Auth::id();

        $file = '/var/www/tokens/' . $id;

        $V = new VSee();

        $result = $V->getSSOToken($first, $last, $dob, $email);

        $token = $result->data->token->token;

        $id = $result->data->id;

        if (!file_exists($file)) {

            file_put_contents($file, $id);

        }

        $url = "https://trackmysolutions.vsee.me/auth?sso_token=$token&next=/";

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
}
