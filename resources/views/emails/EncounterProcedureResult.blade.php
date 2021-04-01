@component('mail::message')

{{__('Hello')}} {{$first_name}},

{{__('A new test result has been added to your account.  Please click the link below to log in and view your test result under “My Lab Results”.')}}

[https://trackmylabresults.com](https://trackmylabresults.com)

{{__('Thank you')}},<br>
TrackMy Lab Results 

@endcomponent
