@extends('layouts.app')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>企業名</th>
            <th>発日時・発地 / 着日時・着地</th>
            <th>運賃</th>
            <th>積合</th>
            <th>重量</th>
            <th>車種</th>
            <th>荷種</th>
            <th>ドライバー作業</th>
            <th>備考</th>
            <th>保存</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($loads as $load)
            <tr>
                <td>
                    <a class="btn btn-primary" href="{{ route('load.show', $load->id) }}">詳細</a>
                </td>
                <td>{{ $load->owner->getCompanyAndOfficeName() }}</td>
                <td>
                    <div>
                        <p>{{ $load->getDepartureAt("load_find") }}</p>
                        <p>{{ $load->getDepartureAddress() }}</p>
                    </div>
                    <div>
                        <p>{{ $load->getArrivalAt("load_find") }}</p>
                        <p>{{ $load->getArrivalAddress() }}</p>
                    </div>
                </td>
                <td>
                    <p>{{ number_format($load->fare_amount) }}円</p>
                    <p>参考価格</p>
                    <p>高速代{{ $load->is_highway_fare ? "あり" : "なし" }}</p>
                </td>
                <td>{{ $load->is_mixed ? "○" : "×" }}</td>
                <td>{{ $load->truck_capacity_type->name }}</td>
                <td>{{ $load->truck_cargo_type->name }}</td>
                <td>部材</td>
                <td>未入力</td>
                <td>{{ $load->memo }}</td>
                <td>
                    <form action="{{ route('bookmark.load.toggle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="load_id" value="{{ $load->id }}">
                        <button class="btn btn-primary">{{ $load->hasBookmark() ? "解除" : "保存" }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection