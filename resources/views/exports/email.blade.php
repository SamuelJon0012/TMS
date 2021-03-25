<table>
    <thead>
    <tr>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
        @foreach($emails as $email)
            @if ($email)
                <tr>
                    <td>{{ $email }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
