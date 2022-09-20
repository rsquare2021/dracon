@extends('layouts.app')

@section('content')
<form action="{{ route('user.update') }}" method="POST">
    @csrf
    @method("put")
    <table>
        <tr>
            <th>名前</th>
            <td>
                <input type="text" name="name" value="{{ old('name', $user->name) }}">
                @error('name')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>
                <input type="email" name="email" value="{{ old('email', $user->email) }}">
                @error('email')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <th>役職</th>
            <td>
                <select name="user_role_id">
                    <option value=""></option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @if($role->id == old('user_role_id', $user->user_role_id)) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('user_role_id')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
    </table>
    <button>保存</button>
</form>
@endsection