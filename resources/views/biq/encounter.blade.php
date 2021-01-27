{
  "id": {{(int)$data->getId()}},
  "patient_id": {{(int)$data->getPatientId()}},
  "site_id": {{(int)$data->getSiteId()}},
  "provider_id": {{(int)$data->getProviderId()}},
  "datetime": {{(int)$data->get()}},
  "dx_icd10": ["{{(int)$data->getDxIcd10()}}"],
  "refering_provider_id": "{{(int)$data->getReferringProviderId()}}",
"patient_question_responses": [
    {
      "question_id": ,
      "patient_response": "Sir Lancelot of Camelot"
    },
    {
      "question_id": 2,
      "patient_response": "To Seek the Holy Grail"
    },
    {
      "question_id": 3,
      "patient_response": "Blue"
    },
    {
      "question_id": 4,
      "patient_response": "Which kind of swallow: African or European?"
    }
  ],
  "billing_provider_id": 1,
  "procedures": [
    {
      "id": 1,
      "rendering_provider_id": 1,
      "cpt": ["12345"],
      "reference_number": "56789",
      "model_version_number": "12341234",
      "vendor": "Fred",
      "erp_number": "12341234",
      "tracking_tag_number": "12341234",
      "manufacturer": "McDonalds",
      "udi": "42875623475624387520746524736",
      "udi_di": "24352345",
      "description": "Can't tell, it's in a box",
      "lot_number": "12341234",
      "serial_number": "12341234",
      "manufacturing_date": "2021-01-22T18:25:38.603Z",
      "expiration_date": "2021-01-22T18:25:38.603Z",
      "dose_number": 1,
      "dose_date": "2021-01-22T18:25:38.603Z",
      "size": "1 Millicubit"
    }
  ]
}
