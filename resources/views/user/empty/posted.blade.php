@extends('layouts.app')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>担当者</th>
            <th>空車日時・空車地 / 行先日時・行先地</th>
            <th>運賃</th>
            <th>重量</th>
            <th>車種</th>
            <th>備考</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empties as $empty)
            <tr>
                <td>{{ $empty->contact_name}}</td>
                <td>
                    <div>発： {{ $empty->getDepartureAt() }} {{ $empty->getDepartureAddress() }}</div>
                    <div>着： {{ $empty->getArrivalAt() }} {{ $empty->getArrivalAddress() }}</div>
                </td>
                <td>{{ number_format($empty->fare_amount) }}円</td>
                <td>{{ $empty->truck_capacity_type->name }}</td>
                <td>{{ $empty->truck_cargo_type->name }}</td>
                <td>{{ $empty->memo }}</td>
                <td><a href="{{ route('empty.edit', $empty->id) }}" class="btn btn-info">編集</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
