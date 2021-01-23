@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

          <div class="card">
            <div class="card-header">
              {{ __('Add Vaccine') }}
            </div>
          </div>

          <div class="card-body">

            <form method="POST" action="" onsubmit="javascript: alert('Under Development!!'); return false;">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Vaccine: ') }}</label>

                    <div class="col-md-6">
                        <input id="vaccine" type="text" class="form-control @error('vaccine') is-invalid @enderror" name="vaccine" value="{{ old('vaccine') }}" required autocomplete="vaccine" autofocus>

                        @error('vaccine')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dose_number" class="col-md-4 col-form-label text-md-right">{{ __('Dose Number: ') }}</label>

                    <div class="col-md-6">
                        <input id="dose_number" type="text" class="form-control @error('dose_number') is-invalid @enderror" name="dose_number" value="{{ old('dose_number') }}" required autocomplete="dose_number">

                        @error('dose_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="product_name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name: ') }}</label>

                    <div class="col-md-6">
                        <input id="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ old('product_name') }}" required autocomplete="product_name" >

                        @error('product_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lot_number" class="col-md-4 col-form-label text-md-right">{{ __('Lot Number: ') }}</label>

                    <div class="col-md-6">
                        <input id="lot_number" type="text" class="form-control @error('lot_number') is-invalid @enderror" name="lot_number" value="{{ old('lot_number') }}" required autocomplete="lot_number" >

                        @error('lot_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="manufacturer" class="col-md-4 col-form-label text-md-right">{{ __('Manufacturer: ') }}</label>

                    <div class="col-md-6">
                        <input id="manufacturer" type="text" class="form-control @error('manufacturer') is-invalid @enderror" name="manufacturer" value="{{ old('manufacturer') }}" required autocomplete="manufacturer" >

                        @error('manufacturer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dose_date" class="col-md-4 col-form-label text-md-right">{{ __('Dose Date: ') }}</label>

                    <div class="col-md-6">
                        <input id="dose_date" type="date" class="form-control @error('dose_date') is-invalid @enderror" name="dose_date" value="{{ old('dose_date') }}" required autocomplete="dose_date" >

                        @error('dose_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="provider" class="col-md-4 col-form-label text-md-right">{{ __('Healthcare Professional / Clinical setAttribute: ') }}</label>

                    <div class="col-md-6">
                        <input id="provider" type="text" class="form-control @error('provider') is-invalid @enderror" name="provider" value="{{ old('provider') }}" required autocomplete="provider">

                        @error('provider')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save Vaccine') }}
                        </button>
                    </div>
                </div>
            </form>

          </div>

        </div>
    </div>
</div>
@endsection
