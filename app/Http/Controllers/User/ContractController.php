<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Load;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function apply(Load $load)
    {
        abort_if($load->owner_company_id == Auth::user()->company_id, 404);

        $contract = Contract::firstOrNew([
            "load_id" => $load->id,
            "company_id" => Auth::user()->company_id,
        ]);

        if($contract->id && $contract->status != "cancel") return;

        $contract->status = "apply";
        $contract->save();

        return back()->with("flush_message", "応募しました。");
    }

    public function cancel(Contract $contract)
    {
        $this->authorizeTransporter($contract);
        if($contract->status != "apply") return;

        $contract->status = "cancel";
        $contract->save();

        return back()->with("flush_message", "応募をキャンセルしました。");
    }

    public function confirm(Contract $contract)
    {
        $this->authorizeOwner($contract);

        $is_apply = in_array($contract->status, ["apply", "reject"]);
        $has_other_confirm = $contract->load_item->applies->filter(fn($v) => in_array($v->status, ["confirm", "accept"]))->isNotEmpty();
        if(!$is_apply || $has_other_confirm) return;

        $contract->status = "confirm";
        $contract->save();

        return back()->with("flush_message", "仮成約を送りました。");
    }

    public function cancel_confirm(Contract $contract)
    {
        $this->authorizeOwner($contract);

        if($contract->status != "confirm") return;

        $contract->status = "apply";
        $contract->save();

        return back()->with("flush_message", "仮成約の送信を取り消しました。");
    }

    public function reject(Contract $contract)
    {
        $this->authorizeTransporter($contract);
        if($contract->status != "confirm") return;

        $contract->status = "reject";
        $contract->save();

        return back()->with("flush_message", "仮成約を断りました。");
    }

    public function accept(Contract $contract)
    {
        $this->authorizeTransporter($contract);
        if($contract->status != "confirm") return;

        $contract->status = "accept";
        $contract->save();

        return back()->with("flush_message", "本成約しました。");
    }

    private function authorizeTransporter($contract)
    {
        abort_unless($contract->company_id == Auth::user()->company_id, 404);
    }

    private function authorizeOwner($contract)
    {
        abort_unless($contract->load_item->owner_company_id == Auth::user()->company_id, 404);
    }
}
