@component('mail::layout')
    @slot('header')@endslot
    @slot('subcopy')
        <h1>{{ __('Welcome to Track My Vaccine.') }}</h1>
        <p>{{ __('Thank you for creating your account at Track My Vaccine, and for scheduling your COVID-19 vaccine.') }}</p>
        <p>{{ __('To access your Track My account, please click here:') }} <a href='https://trackmyvaccine.com'>{{ __('https://trackmyvaccine.com') }}</a></p>
        <p>{{ __('If you are not able to access your account, or have difficulty scheduling an appointment, please contact the Call Center at 844-522-5952.') }}</p>
    @endslot
    @slot('footer')@endslot
@endcomponent
