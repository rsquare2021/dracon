@extends('layouts.app')

@section('content')

@if (session('flush_message'))
    <p>{{ session('flush_message') }}</p>
@endif

<form action="{{ $is_create ? route('load.store') : route('load.update', $load->id) }}" method="POST">
    @csrf
    @if(!$is_create) @method('PUT') @endif
    <h5>発</h5>
    <table class="table">
        <tr>
            <th>発日</th>
            <td>
                <input class="form-control" type="date" name="departure_date" value="{{ old('departure_date', $load->departure_date ? $load->departure_date->format('Y-m-d') : '') }}" min="{{ today() }}">
                @error('departure_date')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>発時間</th>
            <td>
                <select class="form-control" name="departure_time">
                    <option value="">指定なし</option>
                    @foreach (range(0, 23) as $hour)
                        <?php $time = str_pad($hour, 2, '0', STR_PAD_LEFT).':00'; ?>
                        <option value="{{ $time }}" @if($time == old('departure_time', $load->departure_time)) selected @endif>{{ $time }}</option>
                    @endforeach
                </select>
                @error('departure_time')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>都道府県</th>
            <td>
                <select class="form-control" name="departure_prefecture_id">
                    @foreach ($prefectures as $pref)
                        <option value="{{ $pref->id }}" @if($pref->id == old('departure_prefecture_id', $load->departure_prefecture_id)) selected @endif>{{ $pref->name }}</option>
                    @endforeach
                </select>
                @error('departure_prefecture_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>市区町村</th>
            <td>
                <input class="form-control" type="text" name="departure_address_1" value="{{ old('departure_address_1', $load->departure_address_1) }}">
                @error('departure_address_1')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>番地・それ以降の住所</th>
            <td>
                <input class="form-control" type="text" name="departure_address_2" value="{{ old('departure_address_2', $load->departure_address_2) }}">
                @error('departure_address_2')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>

    <h5>発</h5>
    <table class="table">
        <tr>
            <th>発日</th>
            <td>
                <input class="form-control" type="date" name="arrival_date" value="{{ old('arrival_date', $load->arrival_date ? $load->arrival_date->format('Y-m-d') : '') }}" min="{{ today() }}">
                @error('arrival_date')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>発時間</th>
            <td>
                <select class="form-control" name="arrival_time">
                    <option value="">指定なし</option>
                    @foreach (range(0, 23) as $hour)
                        <?php $time = str_pad($hour, 2, '0', STR_PAD_LEFT).':00'; ?>
                        <option value="{{ $time }}" @if($time == old('arrival_time', $load->arrival_time)) selected @endif>{{ $time }}</option>
                    @endforeach
                </select>
                @error('arrival_time')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>都道府県</th>
            <td>
                <select class="form-control" name="arrival_prefecture_id">
                    @foreach ($prefectures as $pref)
                        <option value="{{ $pref->id }}" @if($pref->id == old('arrival_prefecture_id', $load->arrival_prefecture_id)) selected @endif>{{ $pref->name }}</option>
                    @endforeach
                </select>
                @error('arrival_prefecture_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>市区町村</th>
            <td>
                <input class="form-control" type="text" name="arrival_address_1" value="{{ old('arrival_address_1', $load->arrival_address_1) }}">
                @error('arrival_address_1')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>番地・それ以降の住所</th>
            <td>
                <input class="form-control" type="text" name="arrival_address_2" value="{{ old('arrival_address_2', $load->arrival_address_2) }}">
                @error('arrival_address_2')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>

    <h5>荷物</h5>
    <table class="table">
        <tr>
            <th>荷種</th>
            <td>
                <input class="form-control" type="text" name="package_content" value="{{ old('package_content', $load->package_content) }}">
                @error('package_content')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>荷物の個数（目安）</th>
            <td>
                <input class="form-control" type="number" name="package_count" value="{{ old('package_count', $load->package_count) }}" min="1">
                @error('package_count')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>荷物の体積（㎥）</th>
            <td>
                <input class="form-control" type="number" name="total_cubic_size" value="{{ old('total_cubic_size', $load->total_cubic_size) }}" step="0.1" min="0.1">
                @error('total_cubic_size')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>総重量（Kg）</th>
            <td>
                <input class="form-control" type="number" name="total_weight" value="{{ old('total_weight', $load->total_weight) }}" min="1">
                @error('total_weight')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>ドライバー作業</th>
            <td>
                <div>
                    <span>積み</span>
                    <select class="form-control" name="carry_in_driver_work_id">
                        <option value=""></option>
                        @foreach ($driver_works as $work)
                            <option value="{{ $work->id }}" @if($work->id == old('carry_in_driver_work_id', $load->carry_in_driver_work_id)) selected @endif>{{ $work->name }}</option>
                        @endforeach
                    </select>
                    @error('carry_in_driver_work_id')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-2">
                    <span>卸し</span>
                    <select class="form-control" name="carry_out_driver_work_id">
                        <option value=""></option>
                        @foreach ($driver_works as $work)
                            <option value="{{ $work->id }}" @if($work->id == old('carry_out_driver_work_id', $load->carry_out_driver_work_id)) selected @endif>{{ $work->name }}</option>
                        @endforeach
                    </select>
                    @error('carry_out_driver_work_id')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>
            </td>
        </tr>
        <tr>
            <th>混載便</th>
            <td>貸切指定・混載OKのチェックボックス</td>
        </tr>
    </table>

    <h5>車両</h5>
    <table class="table">
        <tr>
            <th>車両</th>
            <td>
                軽・小型・中型・大型・トレーラーのチェックボックス
                <select class="form-control" name="truck_capacity_type_id">
                    <option value="">重量問わず</option>
                    @foreach ($truck_capacity_types as $capacity)
                        <option value="{{ $capacity->id }}" @if($capacity->id == old('truck_capacity_type_id', $load->truck_capacity_type_id)) selected @endif>{{ $capacity->name }}</option>
                    @endforeach
                </select>
                @error('truck_capacity_type_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
                <select class="form-control mt-2" name="truck_cargo_type_id">
                    <option value="">車種問わず</option>
                    @foreach ($truck_cargo_types as $cargo)
                        <option value="{{ $cargo->id }}" @if($cargo->id == old('truck_cargo_type_id', $load->truck_cargo_type_id)) selected @endif>{{ $cargo->name }}</option>
                    @endforeach
                </select>
                @error('truck_cargo_type_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>台数（台）</th>
            <td>
                <input class="form-control" type="number" name="truck_count" min="1" value={{ old('truck_count', ($load->truck_count ?? 1)) }}>
                @error('truck_count')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>運賃（円）</th>
            <td>
                <input class="form-control" type="number" name="fare_amount" min="1" value="{{ old('fare_amount', $load->fare_amount) }}">
                @error('fare_amount')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>高速代</th>
            <td>
                <ul>
                    <li><label><input type="radio" name="is_highway_fare" value="1" @if(old('is_highway_fare', $load->is_highway_fare) == '1') checked @endif>支払う</label></li>
                    <li><label><input type="radio" name="is_highway_fare" value="0" @if(old('is_highway_fare', $load->is_highway_fare) == '0') checked @endif>支払わない</label></li>
                </ul>
                <input type="text" class="form-control" placeholder="内訳" value="">
                @error('is_highway_fare')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>備考</th>
            <td>
                <textarea class="form-control" name="memo" cols="30" rows="2">{{ old('memo', $load->memo) }}</textarea>
                @error('memo')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>その他</th>
            <td>
                <ul>
                    <li><label><input type="checkbox" name="is_urgent" value="1" @if(old('is_urgent', $load->is_urgent)) checked @endif>至急</label></li>
                    <li><label><input type="checkbox" name="is_moved_home" value="1" @if(old('is_moved_home', $load->is_moved_home)) checked @endif>引越し案件</label></li>
                    <li><label><input type="checkbox" name="is_mixed" value="1" @if(old('is_mixed', $load->is_mixed)) checked @endif>積合</label></li>
                </ul>
            </td>
        </tr>
        <tr>
            <th>担当者</th>
            <td>
                <input class="form-control" type="text" name="contact_name" value="{{ old('contact_name', $load->contact_name) }}">
                @error('contact_name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>

    <div>
        <p></p>
        <label><input type="checkbox" name="is_unsettled" value="1" @if(old('is_unsettled', $load->is_unsettled)) checked @endif>商談中の荷物として登録する</label>
        @error('is_unsettled')
            <p class="alert alert-danger">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <button class="btn btn-primary">{{ $is_create ? '登録' : '変更' }}</button>
        <button class="btn btn-danger">クリア</button>
    </div>
    @include('show_validation_error')
</form>
@endsection