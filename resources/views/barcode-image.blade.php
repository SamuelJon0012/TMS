@extends('layouts.app')

@section('content')

    @if(isset($barcodePage))
        <div>
            <div class="modal-dialog" role="document" style="max-width: 880px">
                <div class="modal-content" style="padding: 20px;">
                    <div class="modal-header text-center" style="border-bottom: 0px">
                        <h5 class="modal-title w-100" id="exampleModalLabel">{{ __('Patient Confirmation') }}</h5>                        
                    </div>
                    <div class="row mb-4">
                        <div class="col-6 pl-4">
                            <a style="cursor: pointer;"><i class="fas fa-arrow-left" style="font-size: 12px;"></i> {{ __('Home <-') }}  </a>
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