@extends('layouts.app')

@section('content')
@if (session("flush_message"))
    <p>{{ session("flush_message") }}</p>
@endif

<form action="{{ route('company.basic.update') }}" method="POST">
    @csrf
    @method("put")
    <table class="table">
        <tr>
            <th>住所</th>
            <td>
                <div>
                    <input class="form-control" type="text" name="zipcode" value="{{ old('zipcode', $company->zipcode) }}">
                    @error('zipcode')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <select class="form-control" name="prefecture_id">
                        @foreach ($prefectures as $pref)
                            <option value="{{ $pref->id }}" @if($pref->id == old('prefecture_id', $company->prefecture_id)) selected @endif>{{ $pref->name }}</option>
                        @endforeach
                    </select>
                    @error('prefecture_id')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <input class="form-control" type="text" name="address_1" value="{{ old('address_1', $company->address_1) }}">
                    @error('address_1')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <input class="form-control" type="text" name="address_2" value="{{ old('address_2', $company->address_2) }}">
                    @error('address_2')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>
            </td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>
                <input class="form-control" type="text" name="tel" value="{{ old('tel', $company->tel) }}">
                @error('tel')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>FAX</th>
            <td>
                <input class="form-control" type="text" name="fax" value="{{ old('fax', $company->fax) }}">
                @error('fax')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>車両台数</th>
            <td>
                <input class="form-control" type="number" name="truck_count" value="{{ old('truck_count', $company->truck_count) }}">
                <span>台</span>
                @error('truck_count')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>HPアドレス</th>
            <td>
                <input class="form-control" type="text" name="company_web_url" value="{{ old('company_web_url', $company->company_web_url) }}">
                @error('company_web_url')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>
    <button class="btn btn-primary">保存</button>
</form>
@endsection