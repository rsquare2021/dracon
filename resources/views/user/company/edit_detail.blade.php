@extends('layouts.app')

@section('content')
@if (session("flush_message"))
    <p>{{ session("flush_message") }}</p>
@endif

<form action="{{ route('company.detail.update') }}" method="POST">
    @csrf
    @method("put")
    <table class="table">
        <tr>
            <th>事業内容</th>
            <td>
                <textarea class="form-control" name="business_content" cols="30" rows="4">{{ old('business_content', $company->business_content) }}</textarea>
                @error('business_content')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>代表者</th>
            <td>
                <input class="form-control" type="text" name="representative_name" value="{{ old('representative_name', $company->representative_name) }}">
                @error('representative_name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>設立</th>
            <td>
                <input class="form-control" type="month" name="established_at" value="{{ old('established_at', $company->established_at ? $company->established_at->format('Y-m') : '') }}">
                @error('established_at')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>資本金</th>
            <td>
                <input class="form-control" type="number" name="capital_amount" value="{{ old('capital_amount', $company->capital_amount) }}">
                <span>万円</span>
                @error('capital_amount')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>従業員数</th>
            <td>
                <select class="form-control" name="employee_size_id">
                    <option value=""></option>
                    @foreach ($employee_sizes as $size)
                        <option value="{{ $size->id }}" @if($size->id == old('employee_size_id', $company->employee_size_id)) selected @endif>{{ $size->name }}</option>
                    @endforeach
                </select>
                @error('employee_size_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>事業所所在地</th>
            <td>
                <input class="form-control" type="text" name="office_address" value="{{ old('office_address', $company->office_address) }}">
                @error('office_address')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>売上</th>
            <td>
                <input class="form-control" type="number" name="sales_amount" value="{{ old('sales_amount', $company->sales_amount) }}">
                <span>万円</span>
                @error('sales_amount')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>取引銀行</th>
            <td>
                <input class="form-control" type="text" name="bank_name" value="{{ old('bank_name', $company->bank_name) }}">
                @error('bank_name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>主要取引先</th>
            <td>
                <input class="form-control" type="text" name="main_trading_partner_name" value="{{ old('main_trading_partner_name', $company->main_trading_partner_name) }}">
                @error('main_trading_partner_name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>営業地域</th>
            <td>
                <input class="form-control" type="text" name="business_area_name" value="{{ old('business_area_name', $company->business_area_name) }}">
                @error('business_area_name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>締め月</th>
            <td>当月</td>
        </tr>
        <tr>
            <th>締め日</th>
            <td>
                <input class="form-control" type="text" name="cut_off_day" value="{{ old('cut_off_day', $company->cut_off_day) }}">
                @error('cut_off_day')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>支払月</th>
            <td>
                <input class="form-control" type="text" name="payment_month" value="{{ old('payment_month', $company->payment_month) }}">
                @error('payment_month')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>支払日</th>
            <td>
                <input class="form-control" type="text" name="payment_day" value="{{ old('payment_day', $company->payment_day) }}">
                @error('payment_day')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>
    <button class="btn btn-primary">保存</button>
</form>
@endsection