{
  "patient_id": {{(int)$data->getPatientId()}},
  "encounter_id": {{(int)$data->getEncounterId()}},
  "procedure_id": {{(int)$data->getProcedureId()}},
  "result": "{{$data->getResult()}}",
  "datetime": "{{$data->getDatetime()}}",
  "expiration_datetime": "{{$data->getExpirationDatetime()}}"
}