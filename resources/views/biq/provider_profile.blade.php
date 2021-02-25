{
  "id": {{(int)$data->getId()}},
  "provider_type": {{(int)$data->getProviderType()}},
  "npi": "{{$data->getNPI()}}",
  "sites": {{json_encode($data->getSites())}}
  "vsee_clinic_id": {{json_encode($data->getVseeClinicId())}}
}
