@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route("barcode.scan") }}" method="post" class="clearfix">
                    @csrf
                    <input type="text" name="barcode"
                           class="form-control form-control-lg border-radius" id="barcode" placeholder="{{ __("Scan Barcode Here") }}">
                    <input type="submit" class="btn btn-primary float-right" value="Scan" id="scanBarcodeButton">
                </form>
            </div>
        </div>
    </div>
    @if(isset($userInfo))
        <div class="modal fadeIn" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 880px">
                <div class="modal-content" style="padding: 20px;">
                    <div class="modal-header text-center" style="border-bottom: 0px">
                        <h5 class="modal-title w-100" id="exampleModalLabel">{{ __('Patient Confirmation') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6 pl-4">
                            <a style="cursor: pointer;"><i class="fas fa-arrow-left" style="font-size: 12px;"></i> {{ __('Home') }}  </a>
                            <a class="ml-2" style="cursor: pointer;"><i class="fas fa-arrow-left"style="font-size: 12px;"></i>{{ __('Search') }}</a>
                        </div>
                    </div>
                    <div class="modal-body mt-2"style="border-top: 1px solid #dee2e6;">
                        <div class="row">
                            <div class="col-6 col_left_right">
                                <div class="rounded_div">
                                    <div class="personal_rounded">
                                        <p class="personal_rounded_p">{{ __('Personal Data') }}</p>
                                        <p class="mt-3 mb-3" style="padding: 0px 14px;">{{ __('Please confirm identity of yourvisitor and the information on this page, then praceed to the next step.') }}</p>
                                        <p class="p_left"><strong>{{ __('First Name') }} </strong></p><p class="p_right first_name">{{ $userInfo->first_name }}</p>
                                        <p class="p_left"><strong>{{ __('Last Name') }} </strong></p><p class="p_right last_name">{{ $userInfo->last_name }}</p>
                                        <p class="p_left"><strong>{{ __('Date of Birth') }} </strong></p><p class="p_right date_of_birth">{{ $userInfo->date_of_birth }}</p>
                                        <p class="p_left"><strong>{{ __('SSN') }} </strong></p><p class="p_right ssn">{{ $userInfo->ssn }}</p>
                                        <p class="p_left"><strong>{{ __('Driver`s License') }} </strong></p><p class="p_right drivers_license">{{ $userInfo->dl_state }}</p>
                                        <p class="p_left"><strong>{{ __('Address') }} </strong></p><p class="p_right address">{{ $userInfo->address1 }}</p>
                                        <p class="p_left"><strong>{{ __('Apt / Unie') }} </strong></p><p class="p_right apt_unit">{{ __('Apt / Unie') }}</p>
                                        <p class="p_left"><strong>{{ __('City') }} </strong></p><p class="p_right city">{{ $userInfo->city }}</p>
                                        <p class="p_left"><strong>{{ __('State') }} </strong></p><p class="p_right state">{{ $userInfo->state }}</p>
                                        <p class="p_left" style="margin-bottom: 15px;"><strong>{{ __('Zipconde') }} </strong></p><p class="p_right zipcode">{{ $userInfo->zipcode }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col_left_right">
                                <div class="rounded_div">
                                    <div class="personal_rounded">
                                        <p class="personal_rounded_p">{{ __('Demographics') }}</p>
                                        <p class="p_left"><strong>{{ __('Email') }} </strong></p><p class="p_right email">{{ $userInfo->email }}</p>
                                        <p class="p_left"><strong>{{ __('Mobile Phone') }} </strong></p><p class="p_right mobile_phone">{{ $userInfo->phone_number }}</p>
                                        <p class="p_left"><strong>{{ __('Home Phone') }} </strong></p><p class="p_right home_phone">{{ __('Home Phone') }}</p>
                                        <p class="p_left"><strong>{{ __('Birth Sex') }} </strong></p><p class="p_right birth_sex">{{ __('Birth Sex') }}</p>
                                        <p class="p_left"><strong>{{ __('Race') }} </strong></p><p class="p_right race">{{ $userInfo->race }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content:center;">
                        <form id="logout-form" action="{{ route("barcode.image") }}" method="POST">
                            @csrf
                            <input type="hidden" name="barcode" value="{{ $barcode }}">
                            <button type="submit" class="btn btn-primary">Confirm Patient</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(isset($barcodePage))
        <div class="modal fadeIn" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 880px">
                <div class="modal-content" style="padding: 20px;">
                    <div class="modal-header text-center" style="border-bottom: 0px">
                        <h5 class="modal-title w-100" id="exampleModalLabel">{{ __('Patient Confirmation') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6 pl-4">
                            <a style="cursor: pointer;"><i class="fas fa-arrow-left" style="font-size: 12px;"></i> {{ __('Home') }}  </a>
                            <a class="ml-2" style="cursor: pointer;"><i class="fas fa-arrow-left"style="font-size: 12px;"></i>{{ __('Search') }}</a>
                        </div>
                    </div>
                    <div class="modal-body mt-2"style="border-top: 1px solid #dee2e6;">
                        <div class="row">
                            <div>
                                <div style="display: flex; flex-direction: row; justify-content: center">
                                    @php
                                        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                                        echo $generator->getBarcode('038K20A_80777-273-10', $generator::TYPE_CODE_128);
                                    @endphp
                                </div>
                                <div style="text-align: center">
                                    <span>{{ $bcCustomerId }}</span>
                                    <span>-</span>
                                    <span>{{ $bcSiteId }}</span>
                                    <span>-</span>
                                    <span>{{ $bcPatientId }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('vendor.laravelusers.scripts.barcode')
@endsection

@include('vendor.laravelusers.partials.styles')

@section("styleCss")
    #scanBarcodeButton {
        margin-top: 10px;
    }
@endsection
