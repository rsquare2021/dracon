<table>
    <thead>
        <tr>
            <th>状態</th>
            <th>運送会社</th>
            <th>TEL</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($applies as $apply)
            <td>{{ $apply->status }}</td>
            <td>{{ $apply->company->name }}</td>
            <td>{{ $apply->company->tel }}</td>
            <td>
                @if ($apply->status == "confirm")
                    <a href="{{ route('contract.cancel_confirm', $apply->id) }}">キャンセル</a>
                @else
                    @if ($load->hasConfirmStatus())
                        <p>仮成約する</p>
                    @else
                        <a href="{{ route('contract.confirm', $apply->id) }}">仮成約を送る</a>
                    @endif
                @endif
            </td>
        @endforeach
    </tbody>
</table>