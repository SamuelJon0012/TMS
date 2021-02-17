<?php

namespace App;
use Illuminate\Http\Request;


/**
 * Class BurstIq
 * @package App
 */
class BurstIq
{
    // Abstract BurstIq model - extend this for each asset

    protected $BI_PUBLIC_KEY;
    protected $BI_BASE_URL;
    protected $BI_USERNAME;
    protected $BI_PASSWORD;

    protected $url, $username='', $password='', $jwt='', $data, $id=0, $asset_id='';

    protected $get=[], $first, $array=[];
    protected $lastCurlError = null;

    // Get this from db

    public $lookup;
    # Put a wrapper around queries to attempt to re-login if jwt is expired?  Or logout the user <-- this

    /**
     * BurstIq constructor.
     * @param false $username
     * @param false $password
     *
     * Optional username and password in constructor
     *
     * You can also pass them with $this->login() method.  login() creates the JWT used by the other methods
     *
     */
    public function __construct($username=false, $password=false) {

        $this->lookup = (array)json_decode(file_get_contents('/var/www/lookup.json'));

        # Do not instantiate this object if the user isn't logged in except for Registration, and right now we don't have this

        # if(user_is_logged_in)
        //$this->jwt = session('bi_jwt', false);
        $this->BI_PUBLIC_KEY = env('BI_PUBLIC_KEY');
        $this->BI_BASE_URL = env('BI_BASE_URL');
#        $this->BI_USERNAME = env('BI_USERNAME');
#        $this->BI_PASSWORD = env('BI_PASSWORD');

//        if (empty($this->jwt)) {
//
//            if ($username && $password) {
//
//                $this->username = $username;
//                $this->password = $password;
//
//            }
//        }


    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    /**
     * @return string|bool Error message or false
     */
    function getJsonError(){
        switch(\json_last_error()){
            case JSON_ERROR_NONE: return false;
            case JSON_ERROR_DEPTH: return 'Maximum stack depth exceeded';
            case JSON_ERROR_STATE_MISMATCH: return 'Underflow or the modes mismatch';
            case JSON_ERROR_CTRL_CHAR: return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX: return 'Syntax error, malformed JSON';
            case JSON_ERROR_UTF8: return 'Malformed UTF-8 characters, possibly incorrectly encoded';
            default: return \json_last_error_msg();
        }
    }

    /**
     * Check for the curl error before populating $this->data by parsing the returned JSON
     * @param string|null $data json returned by curl call
     * @return string|bool returns error message or false
     */
    function checkCurl($data){
        if ($this->lastCurlError){
            if (env('APP_ENV') == 'development') error_log('Curl error - '.$this->lastCurlError);
            return 'Failed to communicate with BurstIq';
        }

        if (!$obj = \json_decode($data)){
            $msg = $this->getJsonError();
            if (env('APP_ENV') == 'development') error_log("Json error - $msg");
            return $msg;
        }

        if (!isset($obj->status)) 
            return $this->error($data);

        if ($obj->status != 200) 
            return $this->error($data);

        $this->data = $obj;
        return false;
    }

    /**
     * @return bool|string
     */
    function status() {

        $this->url = $this->BI_BASE_URL . 'util/privateid';

        return $this->getCurl();
/*
 * TM captures all relevant info for user
 When performing registration action, do:
   a. call /trackmy/util/privateid
   b. store this private id in the users login/credential attributes
   c. call upsert of patient_profile with that new private id, by setting this header
      Authorization = ID xxxxxxxxxxx

    stag ID ef9718dadf578ef7
    prd ID b67afe2ec35e80bb

 */

    }

    /**
     * @return bool|string
     */
    function lookups() {

        $this->url = $this->BI_BASE_URL . 'util/lookups';

        return $this->getCurl();

    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    function login($username, $password) {

        # NOT USED

        $this->username = $username;
        $this->password = $password;

        $this->url = $this->BI_BASE_URL . 'auth/login';

        if ($err = $this->checkCurl($this->getCurl()))
            return false;

        $this->jwt = $this->data->token;

        session([ 'bi_jwt' => $this->jwt ]);

        return $this->jwt;

    }

    /**
     * @param $chain
     * @param $query
     * @return bool|string
     */
    function query($chain, $query) {

        $postFields = "{
            \"queryTql\": \"$query\"
        }";

        $this->url = $this->BI_BASE_URL . 'query/' . $chain;

        if ($err = $this->checkCurl($this->postCurl($postFields)))
            exit($this->error($err));

        return $this->data;
    }

    /**
     * @param $chain
     * @param $postFields
     * @return bool|string
     */
    function upsert($chain, $postFields) {

        if (gettype($postFields) != 'string') {
            $postFields = json_encode($postFields);
        }

        $this->url = $this->BI_BASE_URL . 'upsert/' . $chain;

        if ($err = $this->checkCurl($this->putCurl($postFields)))
            exit($this->error($err));

        return $this->data;
    }

    /**
     * @return bool|string
     */
    function getCurl() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: ID b67afe2ec35e80bb',
            ),
        ));

        $response = curl_exec($curl);
        $this->lastCurlError = ($response !== null) ? null : '('.\curl_errno($curl).') '.\curl_error($curl);

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
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ID b67afe2ec35e80bb',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $this->lastCurlError = ($response !== null) ? null : '('.\curl_errno($curl).') '.\curl_error($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * @param $postFields
     * @return bool|string
     */
    function putCurl($postFields) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ID b67afe2ec35e80bb',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $this->lastCurlError = ($response !== null) ? null : '('.\curl_errno($curl).') '.\curl_error($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return mixed
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return mixed
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJwt()
    {
        return $this->jwt;
    }

    /**
     * @param  $jwt
     * @return mixed
     */
    public function setJwt($jwt)
    {
        $this->jwt = $jwt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getAssetId(): string
    {
        return $this->asset_id;
    }

    /**
     * @param string $asset_id
     * @return BurstIq
     */
    public function setAssetId(string $asset_id): BurstIq
    {
        $this->asset_id = $asset_id;
        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->get;
    }

    /**
     * @param array $get
     * @return BurstIq
     */
    public function setGet(array $get): BurstIq
    {
        $this->get = $get;
        return $this;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->first;
    }

    /**
     * @param mixed $first
     * @return BurstIq
     */
    public function setFirst($first)
    {
        $this->first = $first;
        return $this;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->array;
    }

    /**
     * @param array $array
     * @return BurstIq
     */
    public function setArray(array $array): BurstIq
    {
        $this->array = $array;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function save() {

        $json = view($this->view)->with(['data' => $this])->render();
//exit($json);
        $results = $this->upsert($this->chain, $json);

        //var_dump($results);

        return $results;

    }

    public function find($query) { //exit($query);

        $this->query($this->chain, $query);

        $records = $this->data->records;

        foreach ($records as $record) {

            $this->make($record);

        }

        return $this;
        # find and store an array of this object with all of the search results.  Make a first, get and toArray method (in base class?)

    }

    function error($msg = 'An error has occurred')
    {

        return json_encode([
            'success' => false,
            'message' => $msg,
        ]);
    }

function enum($key, $val) {

        return $this->lookup[$key][$val];


}


}
