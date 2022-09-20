<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = Auth::user()->company->users;
        // TRABOX: 設定　＝＞　ユーザー管理ページ
        return view("user.user.index", [
            "users" => $users,
        ]);
    }

    public function create()
    {
        $roles = UserRole::get();
        // TRABOX: 設定　＝＞　ユーザー管理ページ　＝＞　画面右上のユーザー追加
        return view("user.user.create", [
            "roles" => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $safe_data = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "user_role_id" => ["required", "exists:user_roles,id"],
        ]);

        $user = new User($safe_data);
        $user->company_id = Auth::user()->company_id;
        $user->save();
        // パスワードが空欄なので、申請受理後にユーザー宛てにパスワード変更メールを送信してあげると良さそうか。

        return redirect()->route("user.index");
    }

    public function edit()
    {
        $user = Auth::user();
        $roles = UserRole::get();
        // TRABOX: 設定　＝＞　ユーザー管理　＝＞　ユーザー一覧テーブルの編集ボタン
        return view("user.user.profile", [
            "user" => $user,
            "roles" => $roles,
        ]);
    }

    public function update(Request $request)
    {
        $safe_data = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "user_role_id" => ["required", "exists:user_roles,id"],
        ]);

        /** @var User */
        $user = Auth::user();
        $user->fill($safe_data);
        $user->save();

        return redirect()->route("user.index");
    }
}
