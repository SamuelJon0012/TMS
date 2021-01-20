<?php

namespace App;
use Illuminate\Http\Request;



class BurstIq
{
    // Abstract BurstIq model - extend this for each asset

    const BI_USERNAME = 'erik.olson@trackmysolutions.us'; // this will be the actual user username
    const BI_PASSWORD = 'Mermaid7!!'; // this will be the actual user password
    const BI_PUBLIC_KEY = '5e30e5d7ac277901e92dbae9f5c6d17126a8463a'; // put this in .env
    const BI_BASE_URL = 'https://stage-trackmy.burstiq.com/trackmy/'; // ''

    protected $url, $username, $password, $jwt, $data;

    # Put a wrapper around queries to attempt to re-login if jwt is expired?  Or logout the user <-- this

    public function __construct() {

        # Do not instantiate this object if the user isn't logged in except for Registration, and right now we don't have this

        # if(user_is_logged_in) { ...

        $this->username = self::BI_USERNAME;
        $this->password = self::BI_PASSWORD;

        $this->jwt = session('bi_jwt', false);

        if (empty($this->jwt)) {

            $this->login();

        }
    }

    function status() {

        $this->url = self::BI_BASE_URL . 'util/status';

        return $this->getCurl();


    }

    function login(Request $request = null) {

        $this->username = self::BI_USERNAME;

        $this->password = self::BI_PASSWORD;

        $this->url = self::BI_BASE_URL . 'util/login';

        $json = $this->getCurl();

        $this->data = json_decode($json);

        $this->jwt = $this->data->token;

        session([ 'bi_jwt' => $this->jwt ]);

        return $this->jwt;


    }

    function query($chain, $query) {

        $postFields = "{
            \"queryTql\": \"$query\"
        }";

        $this->url = self::BI_BASE_URL . 'query/' . $chain;

        return $this->postCurl($postFields);

    }

    function upsert($chain, $postFields) {

        if (gettype($postFields) != 'string') {
            $postFields = json_encode($postFields);
        }

        $this->url = self::BI_BASE_URL . 'upsert/' . $chain;

        return $this->putCurl($postFields);

    }

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

}
