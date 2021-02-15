{{-- 
Parameters:
  id: the unique ID for the "page"
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
          $('.modals').each(function(){
              $(this).hide();
          });
      },
      show: function(element){
          Modals.hideAll();
          if (typeof element == 'string')
              element = document.getElementById(element);
          if (!element)
              return;
          $(element).show();
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
          var lst = e.getElementsByClassName('bread-crumb');
          if (lst.length == 0){
              Modals.hideAll();
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
</style>
@endpush
@endonce

@php
  $breadCrumbs = $breadCrumbs ?? [];
@endphp
<div id="{{ $id }}" class="modals" style="display: none">

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
                    $onclick = 'Modals.hideAll()';
                ?>
                <span class="bread-crumb <?=($itm['className']??'')?>" onclick="<?=$onclick?>" >
                    « {{ __($itm['caption']) }}
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