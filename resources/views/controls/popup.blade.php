{{--
Parameters:
    id: the elements id
    title: the optional title of the popup
    width: default 48pc;
--}}

@once
    @push('pageHeader')
        <style>
        .popup-outer{
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: #000a;
            display: none;
            flex-direction: column;
            z-index: 10;
            overscroll-behavior: contain;
            overflow: scroll;
        }

        .popup-inner{
            max-width: 48pc;
            background: #eeef;
            display: inline-block;
            margin: 4pc auto;
            padding: 2pc;
            box-shadow: 0.1pc 0.1pc 0.2pc #0004;
        }

        .popup-title{
            font-size: 120%;
            font-weight: bold;
            padding-bottom: 0.5pc;
            margin-bottom: 0.5pc;
            border-bottom: 1px solid var(--blue);
            text-align: center;
        }
        </style>
    @endpush

    @push('pageBottom')
        <script>
            Popup = {};

            Popup.show = function(e){
                if (typeof e == 'string')
                    e = document.getElementById(e);
                $(e).fadeIn();
            }

            Popup.hide = function(e){
                if (typeof e == 'string')
                    e = document.getElementById(e);
                $(e).fadeOut();
            }

        </script>
    @endpush
@endonce

@php
    $popupId = $id;
    $popupTitle = $title ?? null;
    $popupWidth = $width ?? '49pc';
@endphp

<div class="popup-outer" id="{{ $popupId }}" style="display: none">
    <div style="display: flex">
        <div class="popup-inner"  style="max-width: {{ $popupWidth }}">

            @if(!empty($popupTitle))
                <div class="popup-title">{{ $popupTitle }}</div>
            @endif

            <div class="popup-content">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>
