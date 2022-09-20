@extends('layouts.app')

@section('content')
<a class="btn btn-primary mb-3" href="{{ route('user.create') }}">ユーザー追加</a>
<table class="table">
    <thead>
        <tr>
            <th>担当者</th>
            <th>役職</th>
            <th>メールアドレス</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->user_role->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->id == Auth::user()->id)
                        <a class="btn btn-primary" href="">編集</a>
                    @endif
                    <a class="btn btn-danger" href="">削除</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection