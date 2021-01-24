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

    const BI_PUBLIC_KEY = '5e30e5d7ac277901e92dbae9f5c6d17126a8463a'; // put this in .env
    const BI_BASE_URL = 'https://stage-trackmy.burstiq.com/trackmy/'; // ''


    protected $url, $username='', $password='', $jwt='', $data, $id=0, $asset_id='';

    protected $get=[], $first, $array=[];

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

        # Do not instantiate this object if the user isn't logged in except for Registration, and right now we don't have this

        # if(user_is_logged_in)

        $this->jwt = session('bi_jwt', false);

        if (empty($this->jwt)) {

            if ($username && $password) {

                $this->username  = $username;
                $this->password = $password;

                $this->login($username, $password);

            }

        }
    }

    /**
     * @return bool|string
     */
    function status() {

        $this->url = self::BI_BASE_URL . 'util/status';

        return $this->getCurl();


    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    function login($username, $password) {

        $this->username = $username;
        $this->password = $password;

        $this->url = self::BI_BASE_URL . 'util/login';

        $json = $this->getCurl();

        $this->data = json_decode($json);

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

        $this->url = self::BI_BASE_URL . 'query/' . $chain;

        return $this->postCurl($postFields);

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

        $this->url = self::BI_BASE_URL . 'upsert/' . $chain;

        return $this->putCurl($postFields);

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
                'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password)
            ),
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
                'Authorization: Bearer ' . $this->jwt,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

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
                'Authorization: Bearer ' . $this->jwt,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

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

        //var_dump($json);

        $results = $this->upsert($this->chain, $json);

        //var_dump($results);

        return $results;

    }

    public function find($query) {

        # Todo: Try Catch the heck out of this kind of stuff, check for $data->status = 200, etc
//exit($query);

        $json = $this->query($this->chain, $query);

        $this->data = json_decode($json);

        # Test for json error here Todo:

        if ($this->data->status != 200) {

            return false;

        }

        $records = $this->data->records;

        foreach ($records as $record) {

            $this->make($record);

        }

        return $this;
        # find and store an array of this object with all of the search results.  Make a first, get and toArray method (in base class?)

    }

//    function make($record) {
//
//        // you must implement this in the child class
//
//        return [];
//
//    }

}
