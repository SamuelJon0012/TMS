{
    "id": {{(int)$data->getId()}},
    "email": "{{$data->getEmail()}}",
    "first_name": "{{$data->getFirstName()}}",
    "last_name": "{{$data->getLastName()}}",
@if(env('BI_VERSION', '4.6') == '4.6')
    "relationship_to_owner": "{{$data->getRelationshipToOwner()}}",
@elseif(env('BI_VERSION') == '4.7')
    "relationship_to_owner": {{$data->getRelationshipToOwner()}},
    "middle_name": "{{$data->getMiddleName()}}",
@endif
    "date_of_birth":{!!json_encode($data->getDateOfBirth())!!},
    "address1":"{{$data->getAddress1()}}",
    "address2":"{{$data->getAddress2()}}",
    "city":"{{$data->getCity()}}",
    "state":"{{$data->getState()}}",
    "zipcode":"{{$data->getZipcode()}}",
    "ssn":"{{$data->getSsn()}}",
    "dl_state":"{{$data->getDlState()}}",
    "dl_number":"{{$data->getDlNumber()}}",
    "ethnicity":"{{$data->getEthnicity()}}",
    "race":"{{$data->getRace()}}",
    "vsee_clinic_id":"{{$data->getVseeClinicId()}}",
    "phone_numbers": {!!json_encode($data->getPhoneNumbers())!!},
    "insurance": {!!json_encode($data->getInsurances())!!},
    "birth_sex": {{(int)$data->getBirthSex()}}
    }
