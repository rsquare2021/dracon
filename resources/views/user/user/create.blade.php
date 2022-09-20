@extends('layouts.app')

@section('content')
<form action="{{ route('user.store') }}" method="POST">
    @csrf
    <table class="table">
        <tr>
            <th>名前</th>
            <td>
                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>役職</th>
            <td>
                <select class="form-control" name="user_role_id">
                    <option value=""></option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @if($role->id == old('user_role_id')) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('user_role_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>
    <button class="btn btn-primary">追加</button>
</form>
@endsection