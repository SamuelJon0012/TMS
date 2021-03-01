{
  "id": {{(int)$data->getId()}},
  "first_name": "{{$data->getFirstName()}}",
  "last_name": "{{$data->getLastName()}}",
  "middle_name": "{{$data->getMiddleName()}}",
  "provider_type": {{(int)$data->getProviderType()}},
  "npi": "{{$data->getNPI()}}",
  "sites": {{json_encode($data->getSites())}}
  "vsee_clinic_id": {{json_encode($data->getVseeClinicId())}}
}
