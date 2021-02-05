<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoverController extends Controller
{
    //

    function vaccineGet(Request $request) {

        return view('auth.cover', [ 'message' => 'Enter your e-mail address to Affirm']);

    }

    function vaccinePost(Request $request) {

        //$B = new BurstIq();

        $data = json_encode($_POST);

        // Spool pq = patient questionnaire, vs = vsee

        file_put_contents ('/var/www/data/aff' . uniqid(true), $data);

        return view('auth.thanks');

    }

    function vaccinePostAffirm(Request $request) {

        //$B = new BurstIq();

        $data = json_encode($_POST);

        $json=file_get_contents('email.json');

        $data = json_decode(preg_replace('/[\x00-\x1F\x7F]/', '', $json));

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $msg = false;
                break;
            case JSON_ERROR_DEPTH:
                $msg =  ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $msg =  ' - Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $msg =  ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $msg =  ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $msg =  ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $msg =  ' - Unknown error';
                break;
        }

        if (!empty($msg)) { exit($msg);}


         echo $request->get('email');
        //var_dump($data);exit;

        if (in_array(strtolower($request->get('email')), $data)) {

            return redirect('/register?rt=patient' );

        } else

            return view('auth.cover', [ 'message' => 'Please enter the email address with which you received this link'] );



    }


}
