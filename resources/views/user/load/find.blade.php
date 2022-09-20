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
                <span>円以上</span>
            </div>
        </div>
        <h5>車種</h5>
        <div class="row">
            <div class="col-2">
                <select class="form-control" name="cp">
                    <option value=""></option>
                    @foreach ($truck_capacity_types as $capacity_type)
                        <option value="{{ $capacity_type->id }}" @if($capacity_type->id == old('cp', $param['cp'] ?? '')) selected @endif>{{ $capacity_type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-10">
                <label><input type="checkbox" name="cp_ia" value="1" @if(old('cp_ia', $param['cp_ia'] ?? '')) checked @endif>問わずを除く</label>
            </div>
        </div>
        <h5>タイプ</h5>
        <div class="row">
            <div class="col-2">
                <select class="form-control" name="cg">
                    <option value=""></option>
                    @foreach ($truck_cargo_types as $cargo_type)
                        <option value="{{ $cargo_type->id }}" @if($cargo_type->id == old('cg', $param['cg'] ?? '')) selected @endif>{{ $cargo_type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-10">
                <label><input type="checkbox" name="cg_ia" value="1" @if(old('cg_ia', $param['cg_ia'] ?? '')) checked @endif>問わずを除く</label>
            </div>
        </div>
        <h5>その他</h5>
        <div>
            <label><input type="checkbox" name="xo" value="1" @if(old('xo', $param['xo'] ?? '')) checked @endif>積合のみ</label>
            <label><input type="checkbox" name="xi" value="1" @if(old('xi', $param['xi'] ?? '')) checked @endif>積合を除く</label>
            <label><input type="checkbox" name="mo" value="1" @if(old('mo', $param['mo'] ?? '')) checked @endif>引越しのみ</label>
            <label><input type="checkbox" name="mi" value="1" @if(old('mi', $param['mi'] ?? '')) checked @endif>引越しを除く</label>
        </div>
        <h5>キーワード</h5>
        <div>
            <input class="form-control" type="text" name="l" value="{{ old('l', $param['l'] ?? '') }}">
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
                <tr data-load="{{ $load->id }}">
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
                    <td>{{ $load->package_content }}</td>
                    <td>{{ $load->getDriverWorkCaption("integrate") }}</td>
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
</section>
@endsection