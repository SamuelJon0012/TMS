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

            <form method="POST" action="{{ route('patientvaccine.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Vaccine: ') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dose_number" class="col-md-4 col-form-label text-md-right">{{ __('Dose Number: ') }}</label>

                    <div class="col-md-6">
                        <select id="dose_number" class="form-control @error('dose_number') is-invalid @enderror" name="dose_number" required>
                          <option value="1">{{ __('First Dose') }}</option>
                          <option value="2">{{ __('Second Dose') }}</option>
                        </select>

                        @error('dose_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>n
                </div>

                <div class="form-group row">
                    <label for="vaccine_name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name: ') }}</label>

                    <div class="col-md-6">
                        <input id="vaccine_name" type="text" class="form-control @error('vaccine_name') is-invalid @enderror" name="vaccine_name" value="{{ old('vaccine_name') }}" required >

                        @error('vaccine_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lot_number" class="col-md-4 col-form-label text-md-right">{{ __('Lot Number: ') }}</label>

                    <div class="col-md-6">
                        <input id="lot_number" type="text" class="form-control @error('lot_number') is-invalid @enderror" name="lot_number" value="{{ old('lot_number') }}" required >

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
                        <input id="manufacturer" type="text" class="form-control @error('manufacturer') is-invalid @enderror" name="manufacturer" value="{{ old('manufacturer') }}" required >

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
                        <input id="dose_date" type="date" class="form-control @error('dose_date') is-invalid @enderror" name="dose_date" value="{{ old('dose_date') }}" required >

                        @error('dose_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="health_pro" class="col-md-4 col-form-label text-md-right">{{ __('Healthcare Professional / Clinical setAttribute: ') }}</label>

                    <div class="col-md-6">
                        <input id="health_pro" type="text" class="form-control @error('health_pro') is-invalid @enderror" name="health_pro" value="{{ old('health_pro') }}" >

                        @error('health_pro')
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
