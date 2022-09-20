@extends('layouts.app')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>荷物番号</th>
            <th>発日時・発地</th>
            <th>着日時・着地</th>
            <th>荷種</th>
            <th>運賃</th>
            <th>閲覧人数</th>
            <th>重量</th>
            <th>車種</th>
            <th>担当</th>
            <th>備考</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($loads as $load)
            <tr>
                <td>{{ $load->id }}</td>
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
            </tr>
        @endforeach
    </tbody>
</table>
@endsection