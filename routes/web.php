<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes([
    "register" => false,
    "reset" => true,
    "verify" => false,
]);

Route::get('/', 'HomeController@index')->name('home');
Route::get("/register", "Public\PublicController@register")->name("public.register");
Route::post("/record", "Public\PublicController@record")->name("public.record");

// アカウント登録の許可短縮ルート。あとで削除する。
Route::get("/test_createAccount/{registration}", "Public\PublicController@test_createAccount");


Route::middleware("auth")
->namespace("User")
->group(function() {
    // 荷物検索
    Route::get("load/find", "LoadController@find")->name("load.find");
    Route::get("load/{load_id}/show", "LoadController@show")->name("load.show");
    // 保存した荷物
    Route::get("bookmark", "BookmarkController@index")->name("bookmark.index");
    Route::post("bookmark/load", "BookmarkController@toggle")->name("bookmark.load.toggle");
    // 荷物登録
    Route::get("load/create", "LoadController@create")->name("load.create");
    Route::post("load", "LoadController@store")->name("load.store");
    // マイ荷物・成約
    Route::get("mylist/posted", "MylistController@posted")->name("mylist.posting");
    Route::get("mylist/expired", "MylistController@expired")->name("mylist.expired");
    Route::get("mylist/owner", "MylistController@owner")->name("mylist.owner");
    ROute::get("mylist/transporter", "MylistController@transporter")->name("mylist.transporter");
    Route::get("mylist/applied", "MylistController@applied")->name("mylist.applied");
    Route::get("load/{load}/edit", "LoadController@edit")->name("load.edit");
    Route::put("load/{load}", "LoadController@update")->name("load.update");
    Route::get("load/{load}/destroy", "LoadController@destroy")->name("load.destroy");
    // 企業検索
    Route::get("company/find", "CompanyController@find")->name("company.find");
    Route::get("company/show", "CompanyController@show")->name("company.show");
    // 企業管理
    Route::get("company/basic/edit", "CompanyController@editBasic")->name("company.basic.edit");
    Route::put("company/basic", "CompanyController@updateBasic")->name("company.basic.update");
    Route::get("company/detail/edit", "CompanyController@editDetail")->name("company.detail.edit");
    Route::put("company/detail", "CompanyController@updateDetail")->name("company.detail.update");
    Route::get("company/trust/edit", "CompanyController@editTrust")->name("company.trust.edit");
    Route::put("company/trust", "CompanyController@updateTrust")->name("company.trust.update");
    // ユーザー管理
    Route::get("user", "UserController@index")->name("user.index");
    Route::get("user/create", "UserController@create")->name("user.create");
    Route::post("user", "UserController@store")->name("user.store");
    Route::get("profile", "UserController@edit")->name("user.edit");
    Route::put("profile", "UserController@update")->name("user.update");
    // 成約処理
    Route::get("load/{load}/apply", "ContractController@apply")->name("contract.apply");
    Route::get("contract/{contract}/cancel", "ContractController@cancel")->name("contract.cancel");
    Route::get("contract/{contract}/confirm", "ContractController@confirm")->name("contract.confirm");
    Route::get("contract/{contract}/cancel_confirm", "ContractController@cancel_confirm")->name("contract.cancel_confirm");
    Route::get("contract/{contract}/reject", "ContractController@reject")->name("contract.reject");
    Route::get("contract/{contract}/accept", "ContractController@accept")->name("contract.accept");
    // 空車登録
    Route::get("truck/find", "EmptyTruckController@find")->name("empty.find");
    Route::get("truck/create", "EmptyTruckController@create")->name("empty.create");
    Route::post("truck/store", "EmptyTruckController@store")->name("empty.store");
    Route::get("truck/{empty}/edit", "EmptyTruckController@edit")->name("empty.edit");
    Route::put("truck/{empty}/update", "EmptyTruckController@update")->name("empty.update");
    Route::get("truck/posted", "EmptyTruckController@posted")->name("empty.posted");
    Route::delete("truck/{empty}/destroy", "EmptyTruckController@destroy")->name("empty.destroy");
});


Route::prefix("admin")
->name("admin.")
->group(function() {
    Route::namespace("Auth")->group(function() {
        Route::get("login", "LoginController@showAdminLoginForm");
        Route::post("login", "LoginController@adminLogin");
        // Route::get("register", "RegisterController@showAdminRegisterForm");
        // Route::post("register", "RegisterController@registerAdmin");
        Route::get('password/reset', "AdminForgotPasswordController@showLinkRequestForm")->name('password.request');
        Route::post('password/email', "AdminForgotPasswordController@sendResetLinkEmail")->name('password.email');
        Route::get('password/reset/{token}', "AdminResetPasswordController@showResetForm")->name('password.reset');
        Route::post('password/reset', "AdminResetPasswordController@reset")->name('password.update');
    });
    Route::middleware("auth:admin")->group(function() {
        Route::view("", "admin")->name("home");
    });
});
