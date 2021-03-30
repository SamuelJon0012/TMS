@extends('layouts.app')

@push('pageHeader')
    <style>
        .barcode-area{
            background-image: url({{route('barcode',$barcode)}});
            background-repeat-x: no-repeat;
            background-position-x: center;
            background-size: contain;
            height: 4pc;
            max-width: 32pc;
            margin: auto;
        }
    </style>
@endpush

@section('content')
        <div>
            <div class="bread-crumbs" style="max-width: 64pc; margin: auto;">
                <span class="bread-crumb " onclick="document.location='{{route('home')}}'">
                    «&nbsp;home
                </span>
                <span class="bread-crumb " onclick="document.location='{{route('barcode.scan')}}'">
                    «&nbsp;Scan
                </span>
            </div>
            <div class="modal-dialog" role="document" style="max-width: 880px">
                <div class="modal-content" style="padding: 20px;">
                    <div class="modal-header text-center" style="border-bottom: 0px">
                        <h5 class="modal-title w-100" id="exampleModalLabel">{{ __('Patient Confirmation') }}</h5>                        
                    </div>
                    <div class="modal-body mt-2"style="border-top: 1px solid #dee2e6;">
                        <div class="row">
                            <div>
                                <div class="barcode-area" >
                                    &nbsp;
                                </div>
                                <div style="text-align: center; margin-top: 0.5pc;">
                                    {{$barcode}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="button" class="btn btn btn-primary" value="{{__('Print Rapid Antigen Labels')}}" onclick="PrintBarcode('{{$barcode}}')"/>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('pageBottom')
    <script>
        var theFrame;
        function PrintBarcode(barcode){
            if (theFrame){
                theFrame.remove();
                theFrame = null;
            }
            theFrame = document.createElement('iframe');
            theFrame.src = '/barcode-print/'+barcode;
            theFrame.style.position = 'fixed';
            theFrame.style.left = '-100%';
            document.body.appendChild(theFrame);
        }
    </script>
@endpush