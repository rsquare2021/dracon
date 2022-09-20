@extends('layouts.app')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>成約番号</th>
            <th>状態</th>
            <th>荷物番号</th>
            <th>荷主</th>
            <th>発日時・発地</th>
            <th>着日時・着地</th>
            <th>運賃</th>
            <th>高速代</th>
            <th>重量</th>
            <th>車種</th>
            <th>入金予定日</th>
            <th>保証</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contracts as $contract)
            @php
                $load = $contract->load_item;
            @endphp
            <tr>
                <td>{{ $contract->id }}</td>
                <td>{{ $contract->status }}</td>
                <td>{{ $load->id }}</td>
                <td>{{ $load->owner->name }}</td>
                <td>
                    <p>{{ $load->getDepartureAt("") }}</p>
                    <p>{{ $load->getDepartureAddress() }}</p>
                </td>
                <td>
                    <p>{{ $load->getArrivalAt("") }}</p>
                    <p>{{ $load->getArrivalAddress() }}</p>
                </td>
                <td>{{ number_format($load->fare_amount) }}<span>円</span></td>
                <td>{{ $load->is_highway_fare ? "あり" : "なし" }}</td>
                <td>{{ $load->truck_capacity_type->name }}</td>
                <td>{{ $load->truck_cargo_type->name }}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection