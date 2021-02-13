<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Class VSee
 * @package App
 */
class VSee
{
    // Abstract VSee model - extend this for each asset

    const VSEE_API_ENDPOINT = 'https://api-trackmysolutions.vsee.me/api_v3/users/sso.json';

    const VSEE_API_X_ACCOUNT_CODE = 'trackmysolutions';
    const VSEE_API_X_API_KEY = 'c3ed07a763df970b698d952a8959b344'; // TrackMy
    const VSEE_API_X_API_SECRET = '3fc6cccfeee05c3decc5577239da49f5';

    protected $url, $username='', $password='', $data, $id=0, $asset_id='';

    protected $get=[], $first, $array=[];

    protected $token;

    protected $first_name, $last_name, $dob, $email;


    /**
     * VSee constructor.
     *
     */
//    public function __construct() {
//
//    }

    function getSSOToken($first, $last, $dob, $email, $username = false) {

        $last = str_replace('’', '\'', $last); // how are these getting in here?

        $params = [
            'first_name' => $first,
            'last_name' => $last,
            'dob' => $dob,
            'email' => $email,
            'code' => $email,
            'disable_emails' => '0'
        ];

        if ($username) {
            $params['username'] = $username;
        }

        $postFields = '';

        foreach ($params as $key => $value) {

            $postFields .= "$key=$value&";

        }
        $postFields = rtrim($postFields, '&');

        $json = $this->postCurl($postFields);

        $id = Auth::id();

        file_put_contents ('/var/www/data/vs_' . $id . '_' . uniqid(true), $json);

        $data = json_decode($json);

        $msg = $this->decodeError();

        if ($msg == false) {

            // Todo: Store $json in user table (vsee)

            return $data;

        } else {

            return $this->error($msg);
        }
    }

    function decodeError() {

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

        return $msg;
    }


    public function getVisit($id) {

        // token for same previously searched patient

        $this->url = "https://api-trackmysolutions.vsee.me/api_v3/visits/$id.json";

        echo "\n$this->url\n";

        $response = $this->getCurl($this->token);

        return $response;

    }

    public function getVisits($first='Jillian', $last='Raisman', $dob='1991-01-15', $email='jraisman@bucksiu.org') {

        $this->first_name = $first;
        $this->last_name = $last;
        $this->dob = $dob;
        $this->email = $email;

        $result = $this->getSSOToken($first, $last, $dob, $email);

        if (isset($result->data->token->token)) {

            $this->token = $result->data->token->token;

        } else {

            return false;
        }

        $this->url = 'https://api-trackmysolutions.vsee.me/api_v3/visits.json';

        $response = $this->getCurl($this->token);

        return $response;

    }

    /**
     * @return bool|string
     */
    function getCurl($token) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-ApiToken: ' . $token,
                'Content-Type: application/x-www-form-urlencoded'
            )
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    /**
     * @param $postFields
     * @return bool|string
     */
    function postCurl($postFields) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::VSEE_API_ENDPOINT,
            CURLOPT_RETURNTRANSFER => true,
            #CURLOPT_ENCODING => '',
            #CURLOPT_MAXREDIRS => 10,
            #CURLOPT_TIMEOUT => 0,
            #CURLOPT_FOLLOWLOCATION => true,
            #CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => '1',
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => array(
                'X-Accosolutions',
                'X-AccountCode: ' . self::VSEE_API_X_ACCOUNT_CODE,
                'X-ApiKey: ' . self::VSEE_API_X_API_KEY,
                'X-ApiSecret: ' . self::VSEE_API_X_API_SECRET,
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    function error($msg = 'An error has occurred')
    {

        return json_encode([
            'success' => false,
            'message' => $msg,
        ]);
    }


}
