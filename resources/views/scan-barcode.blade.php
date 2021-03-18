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
@endsection

@section("styleCss")
    #scanBarcodeButton {
        margin-top: 10px;
    }
@endsection
