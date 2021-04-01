{
  "id": {{(int)$data->getId()}},
  "appointment_type": "{{$data->getAppointmentType()}}",
  "is_walkin": {{(int)$data->getIsWalkin()}},
  "scheduled_time": "{{$data->getScheduledTime()}}",
  "patient_question_responses": {!! json_encode($data->getPatientQuestionResponses()) !!},
  "patient_id": {{$data->getPatientId()}},
  "site_id": {{$data->getSiteId()}},
  "provider_id": {{$data->getProviderId()}},
  "reminder": {!! json_encode((object)$data->getReminder()) !!}
  }
