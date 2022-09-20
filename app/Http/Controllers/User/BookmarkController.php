<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Load;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $loads = Auth::user()->company->bookmarks;
        // TRABOX: 保存した荷物
        return view("user.bookmark.index", [
            "loads" => $loads,
        ]);
    }

    public function toggle(Request $request)
    {
        $safe_data = $request->validate([
            "load_id" => ["required", "exists:loads,id"],
        ]);

        $load = Load::findOrFail($safe_data["load_id"]);
        $load->bookmarks()->toggle(Auth::user()->company_id);

        if(!$request->ajax()) {
            return back();
        }
    }
}
