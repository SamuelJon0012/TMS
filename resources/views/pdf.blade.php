<style>
    td {
        text-align: center;
    }
</style>
<table style="width: 100%">
    <thead>
        <tr>
            <th width="15%">{{ __('Test Date') }}</th>
            <th>{{ __('Test Type') }}</th>
            <th>{{ __('Result') }}</th>
            <th>{{ __('Result Date & Time') }}</th>
            <th>{{ __('Result Corrected') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
            <tr>
                @foreach($result as $key => $data)
                    <td>{{ $data }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>

</table>
