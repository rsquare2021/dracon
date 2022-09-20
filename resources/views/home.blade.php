@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>

                <div class="card-body">
                    <p><a href="{{ route('load.find') }}">荷物検索</a></p>
                    <p><a href="{{ route('bookmark.index') }}">保存した荷物</a></p>
                    <p><a href="{{ route('load.create') }}">荷物登録</a></p>
                    <p>マイ荷物・成約</p>
                    <ul>
                        <li><a href="{{ route('mylist.posting') }}">募集中</a></li>
                        <li><a href="{{ route('mylist.expired') }}">成約しなかった荷物</a></li>
                        <li><a href="{{ route('mylist.owner') }}">自社荷物の成約</a></li>
                        <li><a href="{{ route('mylist.transporter') }}">受託荷物の成約</a></li>
                        <li><a href="{{ route('mylist.applied') }}">応募中</a></li>
                    </ul>
                    <p>空車登録・検索</p>
                    <ul>
                        <li><a href="{{ route('empty.find') }}">空車検索</a></li>
                        <li><a href="{{ route('empty.create') }}">空車登録</a></li>
                        <li><a href="{{ route('empty.posted') }}">登録した空車情報</a></li>
                    </ul>
                    <p>設定</p>
                    <ul>
                        <li><a href="{{ route('company.basic.edit') }}">企業基本情報</a></li>
                        <li><a href="{{ route('company.detail.edit') }}">企業詳細情報</a></li>
                        <li><a href="{{ route('company.trust.edit') }}">企業信用情報</a></li>
                        <li>企業お支払い情報</li>
                        <li><a href="{{ route('user.index') }}">ユーザー管理</a></li>
                        <li><a href="{{ route('user.create') }}">ユーザー追加</a></li>
                        <li>メール受信設定</li>
                        <li>ご利用金額</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
