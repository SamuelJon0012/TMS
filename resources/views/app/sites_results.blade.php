<style>
.site-search-results{
    margin: 1pc 0;
}
.site-search-result{
    border: 1px solid var(--blue);
    border-radius: 1pc;
    padding: 1pc;
    margin: 1pc 0;
    display: flex;
}
.site-search-result.current{
}
.site-search-result-address{
    flex: 1;
}
.site-search-result-button{

}
@media(max-width: 32pc){
    .site-search-result{
        display: block;
    }
    .site-search-result-button{
        display: flex;
        justify-content: flex-end;
    }
}
</style>

<div class="site-search-results">
    @foreach($rows as $row)
        @php
        if ($row->asset->id === $siteId){
            $class = 'current';
            $btn = '<button class="btn btn-primary" disabled="true">'.__('Current').'</button>';
        } else {
            $class = '';
            $btn = '<button class="btn btn-primary" onclick="switchVaccineLocation('.$row->asset->id.')">'.__('Switch to').'</button>';
        }
        $id = 'siteSearchResult_'.$row->asset->id;
        $a = [
            $row->asset->county,
            $row->asset->state,
            $row->asset->zipcode
        ];
        array_filter($a);
        $s = implode(', ', array_filter($a));

        $a = [
            $row->asset->name,
            $row->asset->address1,
            $row->asset->city,
            $s
        ];
        $address = implode('<br/>', array_filter($a));
        @endphp

        <div class="site-search-result {{ $class }}" id="{{ $id }}">
            <div class="site-search-result-address">
                <?=$address?>
            </div>
            <div class="site-search-result-button">
                <?=$btn?>
            </div>
        </div>
    @endforeach
</div>