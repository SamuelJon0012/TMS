@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session()->has('message'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="col-md-12 text-center">
          <h3 class="text-primary"><b>{{ __('My Profile') }}</b></h3>
        </div>
        <br><br><br>

        @if(Auth::check() && Auth::user()->hasRole('patient'))

        <form method="POST" action="{{route('profile.edit', $user)}}">
          {{ csrf_field() }}
          {{ method_field('patch') }}
          <input type="hidden" name="version" value="2">
          <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="form-reg-header">
                {{ __('REQUIRED FIELDS') }}
              </div>
              <div class="card-body text-center">
                <br>
                {{ __('Please fill all the Required fields to ensure that all necessary information is captured for clinical and billing purposes.') }}
                <br><br>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">
                    <img src="{{ asset('images/email-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="email" type="email" class="form-control-reg @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus placeholder="{{ __('EMAIL') }}" readonly>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">
                    <img src="{{ asset('images/lockpassword-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="password" type="password" class="form-control-reg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('PASSWORD') }}" value="" readonly>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">
                    <img src="{{ asset('images/lockpassword-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="password-confirm" type="password" class="form-control-reg" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('REPEAT PASSWORD') }}" value="" readonly>
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">
                    <img src="{{ asset('images/user-circle-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="first_name" type="text" class="form-control-reg @error('first_name') is-invalid @enderror" name="first_name" value="{{ $jsonobj->first_name }}" required autocomplete="first_name"  placeholder="{{ __('FIRST NAME') }}">

                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">
                    <img src="{{ asset('images/user-circle-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="last_name" type="text" class="form-control-reg @error('last_name') is-invalid @enderror" name="last_name" value="{{ $jsonobj->last_name }}" required autocomplete="last_name" placeholder="{{ __('LAST NAME') }}">

                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">
                    <img src="{{ asset('images/calendar-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="date_of_birth" type="text" class="form-control-reg @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ $jsonobj->date_of_birth }}" required autocomplete="date_of_birth" placeholder="{{ __('DATE OF BIRTH (MM/DD/YYYY)') }}" onfocus="(this.type='date')">

                        @error('date_of_birth')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">
                    <img src="{{ asset('images/phone-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="phone_number" type="text" class="form-control-reg @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $jsonobj->phone_number }}" required autocomplete="phone_number" placeholder="{{ __('PRIMARY PHONE NUMBER') }}">

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="row form-reg-color">
                          <div class="col-4">
                            <input type="radio" name="phone_type" id="Mobile" value="2" @if ($jsonobj->phone_type == "Mobile") checked @endif checked> <label for ="Mobile">{{ __('Mobile') }}</label>
                          </div>
                          <div class="col-4">
                            <input type="radio" name="phone_type" id="Home" value="0" @if ($jsonobj->phone_type == "Home") checked @endif> <label for ="Home">{{ __('Home') }}</label>
                          </div>
                          <div class="col-4">
                            <input type="radio" name="phone_type" id="Work" value="1" @if ($jsonobj->phone_type == "Work") checked @endif> <label for ="Work">{{ __('Work') }}</label>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">
                    <img src="{{ asset('images/user-circle-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="address1" type="text" class="form-control-reg @error('address1') is-invalid @enderror" name="address1" value="{{ $jsonobj->address1 }}" required autocomplete="address1" placeholder="{{ __('ADDRESS 1') }}">

                        @error('address1')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">

                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="address2" type="text" class="form-control-reg @error('address2') is-invalid @enderror" name="address2" value="{{ $jsonobj->address2 }}" autocomplete="address2" placeholder="{{ __('ADDRESS 2') }}">

                        @error('address2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">

                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="city" type="text" class="form-control-reg @error('city') is-invalid @enderror" name="city" value="{{ $jsonobj->city }}" required autocomplete="city" placeholder="{{ __('CITY') }}">

                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                    <div class="col-md-1 m-0 text-right pr-0">

                    </div>
                    <div class="col-md-4 text-center m-0 pl-0">
                        <select id="state" class="form-control-blue @error('state') is-invalid @enderror" name="state" required placeholder="{{ __('STATE') }}">
                          <option value="">STATE</option>
                          <option value="AL" @if ($jsonobj->state == "AL") selected @endif>Alabama</option>
                        	<option value="AK" @if ($jsonobj->state == "AK") selected @endif>Alaska</option>
                        	<option value="AZ" @if ($jsonobj->state == "AZ") selected @endif>Arizona</option>
                        	<option value="AR" @if ($jsonobj->state == "AR") selected @endif>Arkansas</option>
                        	<option value="CA" @if ($jsonobj->state == "CA") selected @endif>California</option>
                        	<option value="CO" @if ($jsonobj->state == "CO") selected @endif>Colorado</option>
                        	<option value="CT" @if ($jsonobj->state == "CT") selected @endif>Connecticut</option>
                        	<option value="DE" @if ($jsonobj->state == "DE") selected @endif>Delaware</option>
                        	<option value="DC" @if ($jsonobj->state == "DC") selected @endif>District Of Columbia</option>
                        	<option value="FL" @if ($jsonobj->state == "FL") selected @endif>Florida</option>
                        	<option value="GA" @if ($jsonobj->state == "GA") selected @endif>Georgia</option>
                        	<option value="HI" @if ($jsonobj->state == "HI") selected @endif>Hawaii</option>
                        	<option value="ID" @if ($jsonobj->state == "ID") selected @endif>Idaho</option>
                        	<option value="IL" @if ($jsonobj->state == "IL") selected @endif>Illinois</option>
                        	<option value="IN" @if ($jsonobj->state == "IN") selected @endif>Indiana</option>
                        	<option value="IA" @if ($jsonobj->state == "IA") selected @endif>Iowa</option>
                        	<option value="KS" @if ($jsonobj->state == "KS") selected @endif>Kansas</option>
                        	<option value="KY" @if ($jsonobj->state == "KY") selected @endif>Kentucky</option>
                        	<option value="LA" @if ($jsonobj->state == "LA") selected @endif>Louisiana</option>
                        	<option value="ME" @if ($jsonobj->state == "ME") selected @endif>Maine</option>
                        	<option value="MD" @if ($jsonobj->state == "MD") selected @endif>Maryland</option>
                        	<option value="MA" @if ($jsonobj->state == "MA") selected @endif>Massachusetts</option>
                        	<option value="MI" @if ($jsonobj->state == "MI") selected @endif>Michigan</option>
                        	<option value="MN" @if ($jsonobj->state == "MN") selected @endif>Minnesota</option>
                        	<option value="MS" @if ($jsonobj->state == "MS") selected @endif>Mississippi</option>
                        	<option value="MO" @if ($jsonobj->state == "MO") selected @endif>Missouri</option>
                        	<option value="MT" @if ($jsonobj->state == "MT") selected @endif>Montana</option>
                        	<option value="NE" @if ($jsonobj->state == "NE") selected @endif>Nebraska</option>
                        	<option value="NV" @if ($jsonobj->state == "NV") selected @endif>Nevada</option>
                        	<option value="NH" @if ($jsonobj->state == "NH") selected @endif>New Hampshire</option>
                        	<option value="NJ" @if ($jsonobj->state == "NJ") selected @endif>New Jersey</option>
                        	<option value="NM" @if ($jsonobj->state == "NM") selected @endif>New Mexico</option>
                        	<option value="NY" @if ($jsonobj->state == "NY") selected @endif>New York</option>
                        	<option value="NC" @if ($jsonobj->state == "NC") selected @endif>North Carolina</option>
                        	<option value="ND" @if ($jsonobj->state == "ND") selected @endif>North Dakota</option>
                        	<option value="OH" @if ($jsonobj->state == "OH") selected @endif>Ohio</option>
                        	<option value="OK" @if ($jsonobj->state == "OK") selected @endif>Oklahoma</option>
                        	<option value="OR" @if ($jsonobj->state == "OR") selected @endif>Oregon</option>
                        	<option value="PA" @if ($jsonobj->state == "PA") selected @endif>Pennsylvania</option>
                        	<option value="RI" @if ($jsonobj->state == "RI") selected @endif>Rhode Island</option>
                        	<option value="SC" @if ($jsonobj->state == "SC") selected @endif>South Carolina</option>
                        	<option value="SD" @if ($jsonobj->state == "SD") selected @endif>South Dakota</option>
                        	<option value="TN" @if ($jsonobj->state == "TN") selected @endif>Tennessee</option>
                        	<option value="TX" @if ($jsonobj->state == "TX") selected @endif>Texas</option>
                        	<option value="UT" @if ($jsonobj->state == "UT") selected @endif>Utah</option>
                        	<option value="VT" @if ($jsonobj->state == "VT") selected @endif>Vermont</option>
                        	<option value="VA" @if ($jsonobj->state == "VA") selected @endif>Virginia</option>
                        	<option value="WA" @if ($jsonobj->state == "WA") selected @endif>Washington</option>
                        	<option value="WV" @if ($jsonobj->state == "WV") selected @endif>West Virginia</option>
                        	<option value="WI" @if ($jsonobj->state == "WI") selected @endif>Wisconsin</option>
                        	<option value="WY" @if ($jsonobj->state == "WY") selected @endif>Wyoming</option>
                        </select>

                        @error('state')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-7 text-center">
                        <input id="zipcode" type="text" class="form-control-reg @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ $jsonobj->zipcode }}" required autocomplete="zipcode" placeholder="{{ __('ZIPCODE') }}">

                        @error('zipcode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="form-reg-header">
                {{ __('DEMOGRAPHIC INFO') }}
              </div>
              <div class="card-body text-center">
                <br>
                {{ __('Please fill out the fields below to provide additional information and to ensure proper identification during the testing and vaccination process.') }}
                <br><br>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">

                  </div>
                  <div class="col-md-11 text-center m-0 pl-0">
                        <input id="phone_number1" type="text" class="form-control-reg @error('phone_number1') is-invalid @enderror" name="phone_number1" value="{{ $jsonobj->phone_number1 }}"  autocomplete="phone_number1"  placeholder="{{ __('SECONDARY PHONE NUMBER (optional)') }}">

                        @error('phone_number1')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                        <div class="row form-reg-color">
                          <div class="col-4">
                            <input type="radio" name="phone_type1" id="Mobile1" value="2" @if ($jsonobj->phone_type1 == "2") checked @endif > <label for ="Mobile1">{{ __('Mobile') }}</label>
                          </div>
                          <div class="col-4">
                            <input type="radio" name="phone_type1" id="Home1" value="0" @if ($jsonobj->phone_type1 == "0") checked @endif> <label for ="Home1">{{ __('Home') }}</label>
                          </div>
                          <div class="col-4">
                            <input type="radio" name="phone_type1" id="Work1" value="1" @if ($jsonobj->phone_type1 == "1") checked @endif> <label for ="Work1">{{ __('Work') }}</label>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">

                  </div>
                    <div class="col-md-4 text-center m-0 pl-0">
                        <select id="dl_state" class="form-control-blue @error('dl_state') is-invalid @enderror" name="dl_state" placeholder="{{ __('STATE (optional)') }}">
                          <option value="">STATE (optional)</option>
                          <option value="AL" @if ($jsonobj->dl_state == "AL") selected @endif>Alabama</option>
                        	<option value="AK" @if ($jsonobj->dl_state == "AK") selected @endif>Alaska</option>
                        	<option value="AZ" @if ($jsonobj->dl_state == "AZ") selected @endif>Arizona</option>
                        	<option value="AR" @if ($jsonobj->dl_state == "AR") selected @endif>Arkansas</option>
                        	<option value="CA" @if ($jsonobj->dl_state == "CA") selected @endif>California</option>
                        	<option value="CO" @if ($jsonobj->dl_state == "CO") selected @endif>Colorado</option>
                        	<option value="CT" @if ($jsonobj->dl_state == "CT") selected @endif>Connecticut</option>
                        	<option value="DE" @if ($jsonobj->dl_state == "DE") selected @endif>Delaware</option>
                        	<option value="DC" @if ($jsonobj->dl_state == "DC") selected @endif>District Of Columbia</option>
                        	<option value="FL" @if ($jsonobj->dl_state == "FL") selected @endif>Florida</option>
                        	<option value="GA" @if ($jsonobj->dl_state == "GA") selected @endif>Georgia</option>
                        	<option value="HI" @if ($jsonobj->dl_state == "HI") selected @endif>Hawaii</option>
                        	<option value="ID" @if ($jsonobj->dl_state == "ID") selected @endif>Idaho</option>
                        	<option value="IL" @if ($jsonobj->dl_state == "IL") selected @endif>Illinois</option>
                        	<option value="IN" @if ($jsonobj->dl_state == "IN") selected @endif>Indiana</option>
                        	<option value="IA" @if ($jsonobj->dl_state == "IA") selected @endif>Iowa</option>
                        	<option value="KS" @if ($jsonobj->dl_state == "KS") selected @endif>Kansas</option>
                        	<option value="KY" @if ($jsonobj->dl_state == "KY") selected @endif>Kentucky</option>
                        	<option value="LA" @if ($jsonobj->dl_state == "LA") selected @endif>Louisiana</option>
                        	<option value="ME" @if ($jsonobj->dl_state == "ME") selected @endif>Maine</option>
                        	<option value="MD" @if ($jsonobj->dl_state == "MD") selected @endif>Maryland</option>
                        	<option value="MA" @if ($jsonobj->dl_state == "MA") selected @endif>Massachusetts</option>
                        	<option value="MI" @if ($jsonobj->dl_state == "MI") selected @endif>Michigan</option>
                        	<option value="MN" @if ($jsonobj->dl_state == "MN") selected @endif>Minnesota</option>
                        	<option value="MS" @if ($jsonobj->dl_state == "MS") selected @endif>Mississippi</option>
                        	<option value="MO" @if ($jsonobj->dl_state == "MO") selected @endif>Missouri</option>
                        	<option value="MT" @if ($jsonobj->dl_state == "MT") selected @endif>Montana</option>
                        	<option value="NE" @if ($jsonobj->dl_state == "NE") selected @endif>Nebraska</option>
                        	<option value="NV" @if ($jsonobj->dl_state == "NV") selected @endif>Nevada</option>
                        	<option value="NH" @if ($jsonobj->dl_state == "NH") selected @endif>New Hampshire</option>
                        	<option value="NJ" @if ($jsonobj->dl_state == "NJ") selected @endif>New Jersey</option>
                        	<option value="NM" @if ($jsonobj->dl_state == "NM") selected @endif>New Mexico</option>
                        	<option value="NY" @if ($jsonobj->dl_state == "NY") selected @endif>New York</option>
                        	<option value="NC" @if ($jsonobj->dl_state == "NC") selected @endif>North Carolina</option>
                        	<option value="ND" @if ($jsonobj->dl_state == "ND") selected @endif>North Dakota</option>
                        	<option value="OH" @if ($jsonobj->dl_state == "OH") selected @endif>Ohio</option>
                        	<option value="OK" @if ($jsonobj->dl_state == "OK") selected @endif>Oklahoma</option>
                        	<option value="OR" @if ($jsonobj->dl_state == "OR") selected @endif>Oregon</option>
                        	<option value="PA" @if ($jsonobj->dl_state == "PA") selected @endif>Pennsylvania</option>
                        	<option value="RI" @if ($jsonobj->dl_state == "RI") selected @endif>Rhode Island</option>
                        	<option value="SC" @if ($jsonobj->dl_state == "SC") selected @endif>South Carolina</option>
                        	<option value="SD" @if ($jsonobj->dl_state == "SD") selected @endif>South Dakota</option>
                        	<option value="TN" @if ($jsonobj->dl_state == "TN") selected @endif>Tennessee</option>
                        	<option value="TX" @if ($jsonobj->dl_state == "TX") selected @endif>Texas</option>
                        	<option value="UT" @if ($jsonobj->dl_state == "UT") selected @endif>Utah</option>
                        	<option value="VT" @if ($jsonobj->dl_state == "VT") selected @endif>Vermont</option>
                        	<option value="VA" @if ($jsonobj->dl_state == "VA") selected @endif>Virginia</option>
                        	<option value="WA" @if ($jsonobj->dl_state == "WA") selected @endif>Washington</option>
                        	<option value="WV" @if ($jsonobj->dl_state == "WV") selected @endif>West Virginia</option>
                        	<option value="WI" @if ($jsonobj->dl_state == "WI") selected @endif>Wisconsin</option>
                        	<option value="WY" @if ($jsonobj->dl_state == "WY") selected @endif>Wyoming</option>
                        </select>

                        @error('dl_state')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-7 text-center">
                        <input id="dl_number" type="text" class="form-control-reg @error('dl_number') is-invalid @enderror" name="dl_number" value="{{ $jsonobj->dl_number }}"  autocomplete="dl_number"  placeholder="{{ __('DRIVER LICENSE NUMBER (optional)') }}">

                        @error('dl_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="form-group row justify-content-center">
                   <div class="col-md-1 m-0 text-right pr-0">

                  </div>
                   <div class="col-md-12 text-center">
                      <select id="ethnicity" required="required" class="form-control @error('ethnicity') is-invalid @enderror" name="ethnicity" placeholder="{{ __('ETHINICITY') }}">
                          <option value="">ETHNICITY</option>
                          <option value="0" @if ($jsonobj->ethnicity == "0") selected @endif>Unknown</option>
                          <option value="1" @if ($jsonobj->ethnicity == "1") selected @endif>Hispanic or Latino</option>
                          <option value="2" @if ($jsonobj->ethnicity == "2") selected @endif>Not Hispanic or Latino</option>
                          <option value="3" @if ($jsonobj->ethnicity == "3") selected @endif>Black or African American</option>
                          <option value="4" @if ($jsonobj->ethnicity == "4") selected @endif>Rather not say</option>
                          <option value="5" @if ($jsonobj->ethnicity == "5") selected @endif>White or Caucasian</option>
                                {{--Old wrong choices--}}
{{--                          <option value="1">Unknown</option>--}}
{{--                          <option value="2">Hispanic or Latino</option>--}}
{{--                          <option value="3">Not Hispanic or Latino</option>--}}
{{--                          <option value="4">Black or African American</option>--}}
{{--                          <option value="5">Rather not say</option>--}}



                      </select>
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-1 m-0 text-right pr-0">

                  </div>
                  <div class="col-md-12 text-center">
                      <select id="race" required="required" class="form-control @error('race') is-invalid @enderror" name="race" placeholder="{{ __('RACE') }}">
                        <option value="">RACE</option>

                          <option value="1" @if ($jsonobj->race == "1") selected @endif>American Indian or Alaska Native</option>
                          <option value="2" @if ($jsonobj->race == "2") selected @endif>Asian</option>
                          <option value="3" @if ($jsonobj->race == "3") selected @endif>Black or African American</option>
                          <option value="4" @if ($jsonobj->race == "4") selected @endif>Native Hawaiian or Other Pacific Islander</option>
                          <option value="7" @if ($jsonobj->race == "7") selected @endif>White</option>
                          <option value="5" @if ($jsonobj->race == "5") selected @endif>Other</option>
                          <option value="6" @if ($jsonobj->race == "6") selected @endif>Rather not say</option>
                      </select>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-md-12 text-center">
                      <select id="birth_sex" required="required" class="form-control @error('birth_sex') is-invalid @enderror" name="birth_sex" placeholder="{{ __('BIRTH SEX') }}">
                          <option value="">BIRTH SEX</option>

                          <option value="1" @if ($jsonobj->birth_sex == "1") selected @endif>Male</option>
                          <option value="2" @if ($jsonobj->birth_sex == "2") selected @endif>Female</option>
                          <option value="0" @if ($jsonobj->birth_sex == "0") selected @endif>Other</option>

                      </select>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                  <div class="col-md-12 text-center">

                    <br><br>
                  </div>
                </div>



                <div class="form-group row justify-content-center">
                  <div class="col-md-8 text-center">
                    <button type="submit" class="btn btn-primary form-control-blue">
                        {{ __('Update Profile') }}
                    </button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        </form>
        @endif

        @if(Auth::check() && Auth::user()->hasRole('provider'))

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="form-reg-header">
                                    {{ __('REQUIRED FIELDS') }}
                                </div>
                                <div class="card-body text-center">
                                    <br>
                                    {{ __('Please fill out all the Required fields to ensure that all neccessary information is captured for clinical and billing purposes.') }}
                                    <br><br>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-1 m-0 text-right pr-0">
                                            <img src="{{ asset('images/email-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                                        </div>
                                        <div class="col-md-11 text-center m-0 pl-0">
                                            <input id="email" type="email" class="form-control-reg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('EMAIL') }}">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-1 m-0 text-right pr-0">
                                            <img src="{{ asset('images/lockpassword-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                                        </div>
                                        <div class="col-md-11 text-center m-0 pl-0">
                                            <input id="password" type="password" class="form-control-reg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('PASSWORD') }}" >

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-1 m-0 text-right pr-0">
                                            <img src="{{ asset('images/lockpassword-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                                        </div>
                                        <div class="col-md-11 text-center m-0 pl-0">
                                            <input id="password-confirm" type="password" class="form-control-reg" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('REPEAT PASSWORD') }}" >
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-1 m-0 text-right pr-0">
                                            <img src="{{ asset('images/user-circle-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                                        </div>
                                        <div class="col-md-11 text-center m-0 pl-0">
                                            <input id="first_name" type="text" class="form-control-reg @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name"  placeholder="{{ __('FIRST NAME') }}">

                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-1 m-0 text-right pr-0">
                                            <img src="{{ asset('images/user-circle-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                                        </div>
                                        <div class="col-md-11 text-center m-0 pl-0">
                                            <input id="last_name" type="text" class="form-control-reg @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" placeholder="{{ __('LAST NAME') }}">

                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-1 m-0 text-right pr-0">
                                            <img src="{{ asset('images/user-circle-icon.png') }}" border=0 alt="ImageIcon" width="32px">
                                        </div>
                                        <div class="col-md-11 text-center m-0 pl-0">
                                            <input id="npi" type="text" class="form-control-reg @error('npi') is-invalid @enderror" name="npi" value="{{ old('npi') }}" autocomplete="npi" placeholder="{{ __('NATIONAL PROVIDER IDENTIFIER (NPI) (Optional)') }}">

                                            @error('npi')
                                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-12 text-left form-reg-color ">
                                            {{ __('SELECT ALL THAT APPLY:') }}
                                            <div class="row">
                                                <div class="col-4 text-left">
                                                    <input type="checkbox" name="is_doctor" id="is_doctor" value="1" > <label for ="is_doctor">{{ __('Doctor') }}</label>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <input type="checkbox" name="is_nurse" id="is_nurse" value="1"> <label for ="is_nurse">{{ __('Nurse') }}</label>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <input type="checkbox" name="is_nurse_practioner" id="is_nurse_practioner" value="1"> <label for ="is_nurse_practioner">{{ __('Nurse Practioner') }}</label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-4 text-left">
                                                    <input type="checkbox" name="is_cna" id="is_cna" value="1"> <label for ="is_cna">{{ __('CNAt') }}</label>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <input type="checkbox" name="is_pa" id="is_pa" value="1"> <label for ="is_pa">{{ __('Physicians Assistant') }}</label>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <input type="checkbox" name="is_emto" id="is_emto" value="1"> <label for ="is_emto">{{ __('EMT / Other') }}</label>
                                                </div>

                                            </div>



                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-12 text-center">

                                            <br><br>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-10 text-center">
                                    <br><br><br>
                                    <input type="hidden" name="r_type" value="{{ request()->get('rt') }}">
                                    <button type="submit" class="btn btn-primary form-control">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>



        @endif


    </div>
    <br><br><br>
</div>
@endsection
