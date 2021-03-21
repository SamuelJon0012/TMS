<style>
.my-vaccines th {

    padding: 0 10px 0 10px

    }

.my-vaccines td {
    padding: 0 10px 0 10px
}
</style>
<div class="my-vaccines">
<table>
    <tr>
        <th>{{ __('Vaccine') }}</th>
        <th>{{ __('Dose') }}</th>
        <th>{{ __('Vendor') }}</th>
        <th>{{ __('Size') }}</th>
        <th>{{ __('Product NDC') }}</th>
        <th>{{ __('Lot Number') }}</th>
        <th>{{ __('Manufacturer') }}</th>
        <th>{{ __('Dose Date') }}</th>
        <th>{{ __('Clinical Site') }}</th>
        <th>{{ __('Bar Code') }}</th>
{{--        <th></th>--}}
    </tr>
    @foreach($rows as $row)
    <tr>
        <td>{{ __('COVID-19') }}</td>
        <td>1</td>
        <td>{{ $row['vendor']??'' }}</td>
        <td>{{ $row['size']??'' }}</td>
        <td>{{ $row['ndc']??'' }}</td>
        <td>{{ $row['lot_number']??'' }}</td>
        <td>{{ $row['manufacturer']??'' }}</td>
        <td>{{ $row['dose_date']??'' }}</td>
        <td>{{ $row['room_name']??'' }}</td>
        <td>{{ $row['barcode']??'' }}</td>
{{--        <td>--}}
{{--            <span class="btn btn-sm btn-small btn-warning adverse-event" onclick="alert('This feature is not currently available');">Adverse Event</span>--}}
{{--        </td>--}}
    </tr>
    @endforeach
</table>
</div>
