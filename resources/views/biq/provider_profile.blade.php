{
  "id": {{(int)$data->getId()}},
  "is_doctor": {{(int)$data->getIsDoctor()}},
  "is_nurse": {{(int)$data->getIsNurse()}},
  "is_nurse_practioner": {{(int)$data->getIsNursePractitioner()}},
  "user_id": {{(int)$data->getUserId()}},
  "npi": "{{$data->getNPI()}}",
  "sites": {{json_encode($data->getSites())}}
}
