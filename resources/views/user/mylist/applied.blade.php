@extends('layouts.app')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>荷物番号</th>
            <th>状態</th>
            <th>発日時・発地</th>
            <th>着日時・着地</th>
            <th>荷種</th>
            <th>運賃</th>
            <th>閲覧人数</th>
            <th>重量</th>
            <th>車種</th>
            <th>担当</th>
            <th>備考</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($applies as $apply)
            @php
                $load = $apply->load_item;
            @endphp
            <tr>
                <td>{{ $load->id }}</td>
                <td>{{ $apply->status }}</td>
                <td>
                    <p>{{ $load->getDepartureAt("") }}</p>
                    <p>{{ $load->getDepartureAddress() }}</p>
                </td>
                <td>
                    <p>{{ $load->getArrivalAt("") }}</p>
                    <p>{{ $load->getArrivalAddress() }}</p>
                </td>
                <td>{{ $load->package_content }}</td>
                <td>{{ number_format($load->fare_amount) }}<span>円</span></td>
                <td>{{ $load->getAccessCount() }}</td>
                <td>{{ $load->truck_capacity_type->name }}</td>
                <td>{{ $load->truck_cargo_type->name }}</td>
                <td>{{ $load->contact_name }}</td>
                <td>{{ $load->memo }}</td>
                <td>
                    @if ($load->trashed())
                        <p>荷物が取り下げられました。</p>
                    @else
                        @if ($apply->updated_at < $load->updated_at)
                            <p>荷物情報が更新されています。</p>
                        @endif
                        @if ($apply->status == "apply")
                            <a class="btn btn-danger" href="{{ route('contract.cancel', $apply->id) }}">キャンセル</a>
                        @elseif ($apply->status == "confirm")
                            <a class="btn btn-primary" href="{{ route('contract.accept', $apply->id) }}">本成約を結ぶ</a>
                            <a class="btn btn-danger" href="{{ route('contract.reject', $apply->id) }}">断る</a>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection