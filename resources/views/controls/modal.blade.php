{{-- 
Parameters:
  id: the unique ID for the "page"
  isHome: boolean, true if initial modal (optional, default: false)
  breadCrumbs:[
    id: page id to show (optional)
    className: class name of the back button ie: go_home (optional)
    onclick: js to call on click (optional) DEFAULT "Modals.hideAll()"
    caption: text for the bread crumb
  ]
--}}

@once
@push('pageBottom')
<script src="{{ asset('js/noBacksies.js') }}"></script>
<script>
    window.Modals = {
        hideAll: function(){
            $('.modals').hide();
        },
        show: function(element){
            Modals.hideAll();
            if (typeof element == 'string')
                element = document.getElementById(element);
            if (!element)
                return;
            $(element).fadeIn();
        },
        showHome: function(){
            Modals.hideAll();
            $('.modals.initial-modal').fadeIn(); 
        },
        getVisible: function(){
            var e = null;
            var lst = document.getElementsByClassName('modals');
            for(var i=0; i < lst.length; i++){
                e = lst[i];
                if ($(e).is(':visible'))
                    return e;
            }
        },
        handleBack: function(){
            var e = Modals.getVisible();
            if (!e)
                return;
            if (e.className.indexOf('initial-modal') != -1)
                return;
            var lst = e.getElementsByClassName('bread-crumb');
            if (lst.length == 0){
                Modals.showHome();
                return;
            }
            e = lst[lst.length-1];
            e.click();
        },
        init: function(){
            noBacksies.onBack = Modals.handleBack;
        }
    }
    $(document).ready(Modals.init);
</script>
<style>
    body {
        overscroll-behavior-y: contain; /* Disables pull-to-refresh  */
    }
    body nav {
        z-index: 10; /* should be in the main css */
    }

    .bread-crumbs{
        margin-bottom: 1pc;
    }
    .bread-crumb{
        padding: 0.2pc;
        cursor: pointer;
        transition: 0.5s;
        margin-right: 0.5pc;
        background: #fff;
        border: 1px solid #fff;
    }
    .bread-crumb:hover{
        box-shadow: 0.05pc 0.05pc 0.2pc rgb(0, 0, 0, 0.5);
        background: #eee;
        border: 1px solid #ddd;
        border-radius: 1pc 0 0 1pc;
    }
    body #preloader {
        z-index: 11;
    }
    .modals.initial-modal{
        display: block;
    }
</style>
@endpush
@endonce

@php
    $breadCrumbs = $breadCrumbs ?? [];
    $isHome = $isHome ?? false;
    $classes = ($isHome) ? 'modals initial-modal' : 'modals';
    $initStyle = ($isHome) ? 'display: block' : 'display: none';
   
@endphp

<div id="{{ $id }}" class="{{ $classes }}" style="{{ $initStyle }}">

    <div class="page-modal-inner modals-inner">
        @if(is_array($breadCrumbs) and (count($breadCrumbs) > 0) )
            <div class="bread-crumbs">
            <?php            
            foreach($breadCrumbs as $itm){
                if (isset($itm['onclick'])){
                    $onclick = $itm['onclick'];
                } else if (isset($itm['id'])){
                    $onclick = "Modals.show('".$itm['id']."')";
                } else
                    $onclick = 'Modals.showHome()';
                ?>
                <span class="bread-crumb <?=($itm['className']??'')?>" onclick="<?=$onclick?>" >
                    «&nbsp;{{ __($itm['caption']) }}
                </span>
                <?php
            }
            ?>
            </div>
        @endif

        <div>
            {{ $slot }}
        </div>

    </div>
</div>