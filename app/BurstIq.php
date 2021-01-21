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


    protected $url, $username, $password, $jwt, $data, $id=0;

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
     * @param string $username
     * @return mixed
     */
    public function setUsername(string $username): PatientProfile
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
    public function setPassword(string $password): PatientProfile
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


}
