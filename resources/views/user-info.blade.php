<?php
    function EchoValues($data){
        ?>
        <table width="100%">
        <?php foreach($data as $name=>$value){?>
            <tr><td align="right"><b>{{__($name)}}</b></td> <td>:</td> <td>{{$value}}</td></tr>
        <?php }?>
        </table>
        <?php
    }
?>

@push('pageHeader')
    <style>
        #UserInfoCards{
            display: flex; 
            flex-direction: row; 
            flex-wrap: wrap;
            max-width: 64pc;
            margin: auto;
        }
        #UserInfoCards .card{
            width: 28pc; 
            margin: 1pc auto;
        }
        #UserInfoCards .form-reg-header{
            padding: 5px 10px;
            left: 50%;
            width: unset;
            transform: translate(-50%,-50%);
            margin: 0;
        }
    </style>
@endpush

@extends('layouts.app')

@section('content')
    <div id="UserInfoCards">
        <div class="card">
            <div class="form-reg-header">
                {{ __('Personal Data') }}
            </div>
            <div style="margin: 2pc 0 1pc 0">
                @php
                EchoValues([
                    'First Name'=>$userInfo->first_name,
                    'Last Name'=>$userInfo->last_name,
                    'Date of Birth'=>$userInfo->date_of_birth,
                    'Address1'=>$userInfo->address1,
                    'Address2'=>$userInfo->address2,
                    'City'=>$userInfo->city,
                    'State'=>$userInfo->state,
                    'Zipcode'=>$userInfo->zipcode
                ]);
                @endphp
            </div>
        </div>
        <div class="card">
            <div class="form-reg-header">
                {{ __('Demographics') }}
            </div>
            <div style="margin: 2pc 0 1pc 0">
                @php
                EchoValues([
                    'Email'=>$userInfo->email,
                    'Primary Phone'=>$userInfo->phone_number,
                    'Birth Sex'=>__($userInfo->birth_sex),
                    'Race' => __($userInfo->race),
                ]);
                @endphp
            </div>
        </div>
    </div>
    <div style="text-align:center;">
        <form name="frmConfirmPatient" action="{{ route("barcode.image") }}" method="POST">
            @csrf
            <input type="hidden" name="barcode" value="{{ $barcode }}">
            <button type="submit" class="btn btn-primary">Confirm Patient</button>
        </form>
    </div>
@endsection    
@include('vendor.laravelusers.partials.styles')
