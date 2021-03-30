{
  "id": {{(int)$data->getId()}},
  "patient_id": {{(int)$data->getPatientId()}},
  "site_id": {{(int)$data->getSiteId()}},
  "provider_id": {{(int)$data->getProviderId()}},
  "datetime": "{{$data->getDatetime()}}",
  "type": {{(int)$data->getType()}},
  "patient_question_responses": {!!json_encode($data->getPatientQuestionResponses())!!},
  "billing_provider_id": {{(int)$data->getBillingProviderId()}},
  "procedures": {!!json_encode($data->getProcedures())!!},
  "customer_product_id": [ {{(int)$data->getCustomerProductId()}} ]
}
