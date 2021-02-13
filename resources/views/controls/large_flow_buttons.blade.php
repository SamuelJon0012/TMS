{{--
Parameters:
    Items: [
        id: the elements id
        image: url to image
        caption: the text to appear on the button
        hint: helpful text to be displayed while mouse over
        url: url to load on click
        onclick: js text to run on click (url takes precedents)
        classnames: class names to add
    ]
--}}

@once
@push('pageHeader')
<style type="text/css">
    .large-flow-buttons{
        display: flex;
        flex-flow: row;
        flex-wrap: nowrap;
        justify-content: space-between;
    }

    .large-flow-button-outer{
        text-align: center;
        font-size: 100%;
        margin: 0px;
        padding: 2pc 0.2pc;
        height: 12pc;
        cursor: pointer;
        border-radius: 12px;
        border: 1px solid #007dc3;
        flex: 1;
        margin: 0.5pc;
        min-width: 6pc;
    }
    .large-flow-button-outer:hover{
        background-color: #ddeeff;
    }
    
    .large-flow-button-caption{

    }
    .large-flow-button-image{
        height: 72px;
    }
    @media (min-width: 32pc){
        .large-flow-button-outer:first-child{
            margin-left: 0px;
        }
        .large-flow-button-outer:last-child{
            margin-right: 0px;
        }
    }
    @media (max-width:32pc){
        .large-flow-buttons{
            flex-wrap: wrap;
        }
        .large-flow-button-outer{
            min-width: 10pc;
            height: 8pc;
            padding: 0.6pc 0.2pc
        }
    }
    @media (max-width:24pc){
        .large-flow-buttons{
            flex-flow: column;
        }
        .large-flow-button-outer{
            display: flex;
            flex-direction: row;
            align-items: center;
            height: 6pc;
        }
        .large-flow-button-caption{
            flex-grow: 1;
            text-align: left;
            padding-left: 0.1pc;
        }
    }
</style>
@endpush
@endonce


<div class="large-flow-buttons">
@if(count($items) > 0)
    @foreach($items as $itm)
        <?php
            $title = $itm['hint'] ?? '';
            $id = $itm['id'] ?? '';
            $classNames = 'large-flow-button-outer '.($itm['classnames']??'');
            if (isset($itm['url']))
                $js = 'document.location = "'.$itm['url'].'";';
            else if (isset($itm['onclick']))
                $js = $itm['onclick'];
            else
                $js = '';
        ?>
        <div class="{{ $classNames }}" id="{{ $id }}" title="{{ $title }}" onclick="{{{ $js }}}">
            @if(isset($itm['image']))
                <img class="large-flow-button-image" src="<?=$itm['image']?>"/>
            @endif
            @if(isset($itm['caption']))
                <div class="large-flow-button-caption">
                    {{ $itm['caption'] }}
                </div>
            @endif
        </div>
    @endforeach
@endif
</div>