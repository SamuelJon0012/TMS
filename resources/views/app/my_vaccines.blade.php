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
    <tr>
        <td>COVID-19</td>
        <td>1</td>
        <td>{{ $vendor }}</td>
        <td>{{ $size }}</td>
        <td>{{ $ndc }}</td>
        <td>{{ $lot_number }}</td>
        <td>{{ $manufacturer }}</td>
        <td>{{ $dose_date }}</td>
        <td>{{ $room_name }}</td>
{{--        <td>--}}
{{--            <span class="btn btn-sm btn-small btn-warning adverse-event" onclick="alert('This feature is not currently available');">Adverse Event</span>--}}
{{--        </td>--}}
    </tr>
</table>
</div>
