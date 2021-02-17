<?php

$json = '{"user_id":"%s","_token":"lCxiYEUBdClmKU5ciBlydAbL6f0ebbjHoHuHnIgv","q1":"No","q2":"No","q3":"No","q4":"No","q5":"No","q6":"No","have_insurance":"No","administrator_name":"","plan_type":"","plan_id":"","employer_name":"","group_id":"","coverage_effective_date":"","primary_cardholder":"","issuer_id":"","insurance_type":"","relationship_to_primary_cardholder":""}';

$u = $argv[1];

if ((!is_numeric($u)) || empty($u)) {

    exit("\nusage: php qmake.php <user_id>\n");

}

$fn = "/var/www/erik/work/i/$u";

$json = sprintf($json, $u);

if (file_Exists($fn)) {
    exit("\nFile already exists\n");
}

file_put_contents($fn, $json);

chmod($fn, 0777);

exit ("\nOK\n");




