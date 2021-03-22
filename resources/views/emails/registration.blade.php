@component('mail::layout')
    @slot('header')@endslot
    @slot('subcopy')
        <h1>Welcome to Track My Vaccine.</h1>
        <p>Thank you for creating your account at Track My Vaccine, and for scheduling your COVID-19 vaccine.</p>
        <p>To access your Track My account, please click here: <a href='https://trackmyvaccine.com'>https://trackmyvaccine.com</a></p>
        <p>If you are not able to access your account, or have difficulty scheduling an appointment, please contact the Call Center at 844-522-5952.</p>
    @endslot
    @slot('footer')@endslot
@endcomponent
