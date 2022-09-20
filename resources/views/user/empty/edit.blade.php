@extends('layouts.app')

@section('content')

@if (session('flush_message'))
    <p>{{ session('flush_message') }}</p>
@endif

<form action="{{ route('empty.update', $empty->id) }}" method="POST">
    @csrf
    @method('PUT')

    <table class="table">
        <tr>
            <th>発日</th>
            <td>
                <input class="form-control" type="date" name="departure_date" value="{{ old('departure_date', $empty->departure_date) }}" min="{{ today() }}">
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
                        <option value="{{ $time }}" @if($time == old('departure_time', $empty->departure_time)) selected @endif>{{ $time }}</option>
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
                        <option value="{{ $pref->id }}" @if($pref->id == old('departure_prefecture_id', $empty->departure_prefecture_id)) selected @endif>{{ $pref->name }}</option>
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
                <input class="form-control" type="text" name="departure_address_1" value="{{ old('departure_address_1', $empty->departure_address_1) }}">
                @error('departure_address_1')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>着日</th>
            <td>
                <input class="form-control" type="date" name="arrival_date" value="{{ old('arrival_date', $empty->arrival_date) }}" min="{{ today() }}">
                @error('arrival_date')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>着時間</th>
            <td>
                <select class="form-control" name="arrival_time">
                    <option value="">指定なし</option>
                    @foreach (range(0, 23) as $hour)
                        <?php $time = str_pad($hour, 2, '0', STR_PAD_LEFT).':00'; ?>
                        <option value="{{ $time }}" @if($time == old('arrival_time', $empty->arrival_time)) selected @endif>{{ $time }}</option>
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
                        <option value="{{ $pref->id }}" @if($pref->id == old('arrival_prefecture_id', $empty->arrival_prefecture_id)) selected @endif>{{ $pref->name }}</option>
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
                <input class="form-control" type="text" name="arrival_address_1" value="{{ old('arrival_address_1', $empty->arrival_address_1) }}">
                @error('arrival_address_1')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>その他対応可能空車地</th>
            <td>
                <select class="form-control" name="departure_around_prefecture_ids[]" multiple>
                    @foreach ($prefectures as $pref)
                        <option value="{{ $pref->id }}" @if($empty->departure_around_prefectures->contains($pref->id)) selected @endif>{{ $pref->name }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <th>その他対応可能行先地</th>
            <td>
                <select class="form-control" name="arrival_around_prefecture_ids[]" multiple>
                    @foreach ($prefectures as $pref)
                        <option value="{{ $pref->id }}" @if($empty->arrival_around_prefectures->contains($pref->id)) selected @endif>{{ $pref->name }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <th>車両</th>
            <td>
                軽・小型・中型・大型・トレーラーのチェックボックス
                <select class="form-control" name="truck_capacity_type_id">
                    <option value="">重量問わず</option>
                    @foreach ($truck_capacity_types as $capacity)
                        <option value="{{ $capacity->id }}" @if($capacity->id == old('truck_capacity_type_id', $empty->truck_capacity_type_id)) selected @endif>{{ $capacity->name }}</option>
                    @endforeach
                </select>
                @error('truck_capacity_type_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
                <select class="form-control mt-2" name="truck_cargo_type_id">
                    <option value="">車種問わず</option>
                    @foreach ($truck_cargo_types as $cargo)
                        <option value="{{ $cargo->id }}" @if($cargo->id == old('truck_cargo_type_id', $empty->truck_cargo_type_id)) selected @endif>{{ $cargo->name }}</option>
                    @endforeach
                </select>
                @error('truck_cargo_type_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>最低運賃（円）</th>
            <td>
                <input class="form-control" type="number" name="fare_amount" min="1" value="{{ old('fare_amount', $empty->fare_amount) }}">
                @error('fare_amount')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>担当者</th>
            <td>
                <input class="form-control" type="text" name="contact_name" value="{{ old('contact_name', $empty->contact_name) }}">
                @error('contact_name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>備考</th>
            <td>
                <textarea class="form-control" name="memo" cols="30" rows="2">{{ old('memo', $empty->memo) }}</textarea>
                @error('memo')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>

    <div>
        <button class="btn btn-primary">登録</button>
    </div>
    @include('show_validation_error')
</form>
@endsection