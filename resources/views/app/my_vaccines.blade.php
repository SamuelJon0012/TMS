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
        <th>Vaccine</th>
        <th>Dose</th>
        <th>Vendor</th>
        <th>Size</th>
        <th>Product NDC</th>
        <th>Lot Number</th>
        <th>Manufacturer</th>
        <th>Dose Date</th>
        <th>Clinical Site</th>
{{--        <th></th>--}}
    </tr>
    @foreach($rows as $row)
    <tr>
        <td>COVID-19</td>
        <td>1</td>
        <td>{{ $row['vendor']??'' }}</td>
        <td>{{ $row['size']??'' }}</td>
        <td>{{ $row['ndc']??'' }}</td>
        <td>{{ $row['lot_number']??'' }}</td>
        <td>{{ $row['manufacturer']??'' }}</td>
        <td>{{ $row['dose_date']??'' }}</td>
        <td>{{ $row['room_name']??'' }}</td>
{{--        <td>--}}
{{--            <span class="btn btn-sm btn-small btn-warning adverse-event" onclick="alert('This feature is not currently available');">Adverse Event</span>--}}
{{--        </td>--}}
    </tr>
    @endforeach
</table>
</div>
