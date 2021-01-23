{
"id": 0,
"is_doctor": {{$data->getIsDoctor()}},
"is_nurse": {{$data->getIsNurse}},
"is_nurse_practioner": {{$data->getIsNursePractitioner}},
"user_id": {{$data->getUserId()}},
"npi": {{$data->getNPI}},
"sites": {{json_encode($data->getSites()}}
}
