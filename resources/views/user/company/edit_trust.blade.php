@extends('layouts.app')

@section('content')
@if (session("flush_message"))
    <p>{{ session("flush_message") }}</p>
@endif

<form action="{{ route('company.trust.update') }}" method="POST">
    @csrf
    @method("put")
    <table class="table">
        <tr>
            <th>加入組織</th>
            <td>
                <input class="form-control" type="text" name="union_name" value="{{ old('union_name', $company->union_name) }}">
                @error('union_name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>国交省認可番号</th>
            <td>
                <input class="form-control" type="text" name="government_license_number" value="{{ old('government_license_number', $company->government_license_number) }}">
                @error('government_license_number')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>デジタコ搭載数</th>
            <td>
                <input class="form-control" type="number" name="digi_tacho_count" value="{{ old('digi_tacho_count', $company->digi_tacho_count) }}">
                <span>台</span>
                @error('digi_tacho_count')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>GPS搭載数</th>
            <td>
                <input class="form-control" type="number" name="gps_count" value="{{ old('gps_count', $company->gps_count) }}">
                <span>台</span>
                @error('gps_count')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>安全性優良事業所認定</th>
            <td>
                <input class="form-control" type="checkbox" name="has_safety_cert" value="1" @if(old('has_safety_cert', $company->has_safety_cert)) checked @endif>
                @error('has_safety_cert')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>グリーン経営認証</th>
            <td>
                <input class="form-control" type="checkbox" name="has_green_cert" value="1" @if(old('has_green_cert', $company->has_green_cert)) checked @endif>
                @error('has_green_cert')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>ISO9000</th>
            <td>
                <input class="form-control" type="checkbox" name="has_iso9000" value="1" @if(old('has_iso9000', $company->has_iso9000)) checked @endif>
                @error('has_iso9000')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>ISO14000</th>
            <td>
                <input class="form-control" type="checkbox" name="has_iso14000" value="1" @if(old('has_iso14000', $company->has_iso14000)) checked @endif>
                @error('has_iso14000')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>ISO39001</th>
            <td>
                <input class="form-control" type="checkbox" name="has_iso39001" value="1" @if(old('has_iso39001', $company->has_iso39001)) checked @endif>
                @error('has_iso39001')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>保険会社名</th>
            <td>
                <input class="form-control" type="text" name="insurance_company_name" value="{{ old('insurance_company_name', $company->insurance_company_name) }}">
                @error('insurance_company_name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>
    <button class="btn btn-primary">保存</button>
</form>
@endsection