@extends('layouts.app')

@section('content')
<section>
    <h4>検索条件</h4>
    <form action="">
        <h5>発地</h5>
        <div class="row">
            <div class="col-4">
                <select class="form-control" name="dp">
                    <option value="">都道府県</option>
                    @foreach ($prefectures as $pref)
                        <option value="{{ $pref->id }}" @if($pref->id == old('dp', $param['dp'] ?? '')) selected @endif>{{ $pref->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <input class="form-control" type="date" name="ds" value="{{ old('ds', $param['ds'] ?? '') }}">
            </div>
            <div class="col-4">
                <input class="form-control" type="date" name="de" value="{{ old('de', $param['de'] ?? '') }}">
            </div>
        </div>
        <h5>着地</h5>
        <div class="row">
            <div class="col-4">
                <select class="form-control" name="ap">
                    <option value="">都道府県</option>
                    @foreach ($prefectures as $pref)
                        <option value="{{ $pref->id }}" @if($pref->id == old('ap', $param['ap'] ?? '')) selected @endif>{{ $pref->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <input class="form-control" type="date" name="as" value="{{ old('as', $param['as'] ?? '') }}">
            </div>
            <div class="col-4">
                <input class="form-control" type="date" name="ae" value="{{ old('ae', $param['ae'] ?? '') }}">
            </div>
        </div>
        <h5>価格</h5>
        <div class="row">
            <div class="col-2">
                <input class="form-control" type="number" name="f" value="{{ old('f', $param['f'] ?? '') }}">
            </div>
            <div class="col-10">
                <span>円以下</span>
            </div>
        </div>
        <h5>車種</h5>
        <div class="row">
            <div class="col-12">
                <select class="form-control" name="cp">
                    <option value=""></option>
                    @foreach ($truck_capacity_types as $capacity_type)
                        <option value="{{ $capacity_type->id }}" @if($capacity_type->id == old('cp', $param['cp'] ?? '')) selected @endif>{{ $capacity_type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <h5>タイプ</h5>
        <div class="row">
            <div class="col-12">
                <select class="form-control" name="cg">
                    <option value=""></option>
                    @foreach ($truck_cargo_types as $cargo_type)
                        <option value="{{ $cargo_type->id }}" @if($cargo_type->id == old('cg', $param['cg'] ?? '')) selected @endif>{{ $cargo_type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn-primary btn mt-3">検索</button>
    </form>
</section>

<section class="mt-4">
    <h4>検索結果</h4>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>企業名</th>
                <th>空車日時・空車地 / 行先日時・行先地</th>
                <th>運賃</th>
                <th>重量</th>
                <th>車種</th>
                <th>備考</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empties as $empty)
                <tr>
                    <td></td>
                    <td>{{ $empty->owner->name}}</td>
                    <td>
                        <div>発： {{ $empty->getDepartureAt() }} {{ $empty->getDepartureAddress() }}</div>
                        <div>着： {{ $empty->getArrivalAt() }} {{ $empty->getArrivalAddress() }}</div>
                    </td>
                    <td>{{ number_format($empty->fare_amount) }}円</td>
                    <td>{{ $empty->truck_capacity_type->name }}</td>
                    <td>{{ $empty->truck_cargo_type->name }}</td>
                    <td>{{ $empty->memo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
