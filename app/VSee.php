<?php namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class VSee
 * @package App
 */
class VSee
{
    // Abstract VSee model - extend this for each asset

    protected $VSEE_API_ENDPOINT;
    protected $VSEE_API_X_ACCOUNT_CODE;
    protected $VSEE_API_X_API_KEY;
    protected $VSEE_API_X_API_SECRET;
    protected $VSEE_API_ADMIN_TOKEN;

    protected $url, $username='', $password='', $data, $id=0, $asset_id='';

    protected $get=[], $first, $array=[];

    protected $first_name, $last_name, $dob, $email;

    public $token;
    public $lastCurlError;

    // Visit status codes
    const STATUS_PENDING    = 10;
    const STATUS_CONFIRMED  = 20;
    const STATUS_INPROGRESS = 25;
    const STATUS_COMPLETED  = 30;
    const STATUS_CANCELLED  = 40;

    const StatusCaptions = [
        self::STATUS_PENDING      => 'pending',
        self::STATUS_CONFIRMED    => 'confirmed',
        self::STATUS_INPROGRESS   => 'in progress',
        self::STATUS_COMPLETED    => 'completed',
        self::STATUS_CANCELLED    => 'cancelled'
    ];

    const USERTYPE_MEMBER = 200;
    const USERTYPE_PROVIDER = 400;
    const USERTYPE_GUEST = 600;

    /**
     * VSee constructor.
     *
     */
    public function __construct() {
        $this->VSEE_API_ENDPOINT       = env('VSEE_API_ENDPOINT',       'https://api-trackmysolutions.vsee.me/api_v3/');
        $this->VSEE_API_X_ACCOUNT_CODE = env('VSEE_API_X_ACCOUNT_CODE', 'trackmysolutions');
        $this->VSEE_API_X_API_KEY      = env('VSEE_API_X_API_KEY',      'c3ed07a763df970b698d952a8959b344');
        $this->VSEE_API_X_API_SECRET   = env('VSEE_API_X_API_SECRET',   '3fc6cccfeee05c3decc5577239da49f5');
        $this->VSEE_API_ADMIN_TOKEN    = env('VSEE_API_ADMIN_TOKEN',    '38bf7043c9e56e1e0797c67f9f94c871');

        $this->VSEE_API_ENDPOINT = rtrim($this->VSEE_API_ENDPOINT,"/"); //ensure url does not have a tailing /

        $this->token = $this->VSEE_API_ADMIN_TOKEN;
    }

    function getSSOToken($first, $last, $dob, $email, $user_type = self::USERTYPE_MEMBER) {

        $last = str_replace('’', '\'', $last); // how are these getting in here?

        $params = [
            'first_name' => $first,
            'last_name' => $last,
            'dob' => $dob,
            'email' => $email,
            'code' => $email,
            'disable_emails' => '0',
            'type' => $user_type,
            'timezone' => 'America/New_York'

        ];

        $this->url = $this->VSEE_API_ENDPOINT.'/users/sso.json';

        if (!$json = $this->postCurl($params))
            return $this->error($this->lastCurlError);

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

        $this->url = $this->VSEE_API_ENDPOINT."/visits/$id.json";

        echo "\n$this->url\n";

        $response = $this->getCurl();

        return $response;

    }

    /**
     * Marks the visit as closed / completed and returns null on success or the error message
     * @param int $visit_id from $visit->id
     * @param int $timestamp the unix time the visit ended
     *
     * @return null|string the error message or null if successful
     */
    public function closeVisit(int $visit_id, $timestamp=null, array $added){

        if (!$this->token)
            abort(500, 'Can not mark the visit as complete with out a token');

        $timestamp = $timestamp ?? time();

        $params = [
            'id' => $visit_id,
            'status' => self::STATUS_COMPLETED,
            'actual_end' => $timestamp,
        ];

        if (!empty($added))
            $params += $added;

        $this->url = $this->VSEE_API_ENDPOINT."/visits/close";

        if (!$response = $this->postCurl($params))
            return $this->lastCurlError;

        if (!$response = json_decode($response))
            return $this->decodeError();

        if ( (isset($response->code)) and ($response->code != 200) )
            return '('.$response->code.') '.$response->message ?? 'Invalid response from VSee';
    }

    /**
     * Changed a visit from confirmed to in-progress and returns null or an error message
     *
     * @param int $visit_id
     * @param int $timestamp unix timestamp when the visit started
     *
     * @return null|string
     */
    public function startVisit(int $visit_id, int $timestamp = null){

        if (!$this->token)
            abort(500, 'Can not mark the visit as complete with out a token');

        $timestamp = $timestamp ?? time();

        $params = [
            'id' => $visit_id,
            'actual_start' => $timestamp,
        ];

        $this->url = $this->VSEE_API_ENDPOINT."/visits/inprogress";

        if (!$response = $this->postCurl($params))
            return $this->lastCurlError;

        if (!$response = json_decode($response))
            return $this->decodeError();

        if ( (isset($response->code)) and ($response->code != 200) )
            return '('.$response->code.') '.$response->message ?? 'Invalid response from VSee';
    }

    /**
     * Deletes the visit and returns null or an error message
     *
     * @param int $visit_id
     *
     * @return null|string
     */
    public function deleteVisit(int $visit_id){
        if (!$this->token)
            abort(500, 'Can not mark the visit as complete with out a token');

        $params = [
            'id' => $visit_id,
        ];

        $this->url = $this->VSEE_API_ENDPOINT."/visits/delete";

        if (!$response = $this->postCurl($params))
            return $this->lastCurlError;

        if (!$response = json_decode($response))
            return $this->decodeError();

        if ( (isset($response->code)) and ($response->code != 200) )
            return '('.$response->code.') '.$response->message ?? 'Invalid response from VSee';
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

        $this->url = $this->VSEE_API_ENDPOINT.'/visits.json';

        $response = $this->getCurl();

        return $response;

    }

    /**
     * @return bool|string
     */
    function getCurl() {

        if (!$this->token)
            abort(500,'VSee token required');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-ApiToken: ' . $this->token,
                'Content-Type: application/x-www-form-urlencoded'
            )
        ));

        $response = curl_exec($curl);

        $this->lastCurlError = ($response !== null) ? null : '('.\curl_errno($curl).') '.\curl_error($curl);

        curl_close($curl);
        return $response;

    }

    /**
     * @param string|array|object $postFields
     * @return bool|string
     */
    function postCurl($postFields) {
        if (!$this->token)
            abort(500,'VSee token required');

        if (is_object($postFields))
            $postFields = (array)$postFields;

        if (is_array($postFields)){
            $a = [];
            foreach($postFields as $key=>&$value)
                $a[] = $key.'='.rawurlencode($value);
            $postFields = implode('&', $a);
        }

        $header = [
            'X-Accosolutions',
            'X-AccountCode: ' . $this->VSEE_API_X_ACCOUNT_CODE,
            'X-ApiKey: ' . $this->VSEE_API_X_API_KEY,
            'X-ApiSecret: ' . $this->VSEE_API_X_API_SECRET,
            'Content-Type: application/x-www-form-urlencoded'
        ];
        if ($this->token)
          $header[] = 'X-ApiToken: '.$this->token;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => '1',
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);

        $this->lastCurlError = ($response !== null) ? null : '('.\curl_errno($curl).') '.\curl_error($curl);

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
