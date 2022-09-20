<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Load;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MylistController extends Controller
{
    public function posted()
    {
        $loads = Load::where("owner_company_id", Auth::user()->company_id)->hasnotContract()->beforeDepartureAt()->get();
        // TRABOX: マイ荷物・成約ページ　＝＞　募集中タブ
        // データがある状態をじっくり確認できていないので、詳細不明。
        // 明細にマウスカーソルすると、交渉中にする・変更・コピー・削除の操作ボタンが出てきたような気がする。
        // 「交渉中にする」は、名称を変えて（応募から選択する等）、その荷物にきている応募の一覧ページにジャンプする？
        // コピーは、この荷物を初期データとして荷物登録にジャンプする？
        return view("user.mylist.posted", [
            "loads" => $loads,
        ]);
    }

    public function expired()
    {
        $loads = Load::where("owner_company_id", Auth::user()->company_id)->hasnotContract()->afterDepartureAt()->get();
        // TRABOX: マイ荷物・成約ページ　＝＞　成約しなかった荷物タブ
        // コピーは、この荷物を初期データとして荷物登録にジャンプする？
        return view("user.mylist.expired", [
            "loads" => $loads,
        ]);
    }

    public function owner()
    {
        $loads = Load::with("contract.company")->where("owner_company_id", Auth::user()->company_id)->hasContract()->get();
        // TRABOX: マイ荷物・成約ページ　＝＞　自社荷物の成約タブ
        // 成約後のやりとりをどうシステム化するか、まだ決まってない。
        return view("user.mylist.owner", [
            "loads" => $loads,
        ]);
    }

    public function transporter()
    {
        $contracts = Contract::with("load_item.owner")
            ->where("company_id", Auth::user()->company_id)
            ->where("status", "accept")
            ->get()
        ;
        // TRABOX: マイ荷物・成約ページ　＝＞　受託荷物の成約タブ
        // 成約後のやりとりをどうシステム化するか、まだ決まってない。
        return view("user.mylist.transporter", [
            "contracts" => $contracts,
        ]);
    }

    public function applied()
    {
        $applies = Contract::with(["load_item" => fn($query) => $query->withTrashed()])
            ->where("company_id", Auth::user()->company_id)
            ->whereNotIn("status", ["cancel", "accept"])
            ->get()
        ;
        // TRABOX: トラボックスには存在しないページ
        // 応募した荷物を一覧表示する。
        // 応募キャンセルができる。
        // 応募が仮成約になっていたら、成約・拒否ができる。
        return view("user.mylist.applied", [
            "applies" => $applies,
        ]);
    }
}
