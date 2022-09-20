<table class="table">
    <thead>
        <tr>
            <th>荷物番号</th>
            <th>発日時</th>
            <th>発地</th>
            <th>着日時</th>
            <th>着地</th>
            <th>値段</th>
            <th>高速代</th>
            <th>保存</th>
            <th>応募</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $load->id }}</td>
            <td>{{ $load->getDepartureAt("load_show") }}</td>
            <td>{{ $load->getDepartureAddress() }}</td>
            <td>{{ $load->getArrivalAt("load_show") }}</td>
            <td>{{ $load->getArrivalAddress() }}</td>
            <td>{{ number_format($load->fare_amount) }}</td>
            <td>{{ $load->is_highway_fare ? "あり" : "なし"}}</td>
            <td>
                <form action="{{ route('bookmark.load.toggle') }}" method="POST">
                    @csrf
                    <input type="hidden" name="load_id" value="{{ $load->id }}">
                    <button class="btn btn-primary">{{ $load->hasBookmark() ? "解除" : "保存" }}</button>
                </form>
            </td>
            <td>
                @if (!$load->canApply())
                    @if ($load->contract && $load->contract->company_id == Auth::user()->company_id)
                        <p>成約済み</p>
                    @else
                        <p>取り下げ済み</p>
                    @endif
                @else
                    @if ($apply = $load->applies->first(fn($apply) => $apply->company_id == Auth::user()->company_id))
                        <p>応募済み</p>
                        <a class="btn btn-primary" href="{{ route('contract.cancel', $apply->id) }}">キャンセル</a>
                    @else
                        <a class="btn btn-primary" href="{{ route('contract.apply', $load->id) }}">応募する</a>
                    @endif
                @endif
            </td>
        </tr>
    </tbody>
</table>

<table class="table">
    <tr>
        <th>企業名</th>
        <td>
            <p>{{ $load->owner->getCompanyAndOfficeName() }}</p>
            <a href="{{ route('load.find', ['co' => $load->owner_company_id]) }}">この企業の他の荷物をみる</a>
        </td>
    </tr>
    <tr>
        <th>担当者</th>
        <td>
            <span>{{ $load->contact_name }}</span>
            <span>{{ $load->tel }}</span>
        </td>
    </tr>
    <tr>
        <th>荷種</th>
        <td>
            <p>{{ $load->package_content }}</p>
            <p>総重量：{{ number_format($load->total_weight) }}kg</p>
            <p>ドライバー作業：[積み]{{ $load->getDriverWorkCaption("carry_in") }}[卸し]{{ $load->getDriverWorkCaption("carry_out") }}</p>
            <p>
                積合：{{ $load->is_mixed ? "○" : "×" }}
                / 至急：{{ $load->is_urgent ? "○" : "×" }}
                / 引越し案件：{{ $load->is_moved_home ? "○" : "×" }}
            </p>
        </td>
    </tr>
    <tr>
        <th>備考</th>
        <td>{!! nl2br(e($load->memo)) !!}</td>
    </tr>
    <tr>
        <th>発着日時</th>
        <td>
            <span>{{ $load->getDepartureAt("load_show_full") }}</span>
            -
            <span>{{ $load->getArrivalAt("load_show_full") }}</span>
        </td>
    </tr>
    <tr>
        <th>登録日時</th>
        <td>{{ $load->created_at->isoFormat("YYYY年M月D日(ddd) HH:mm") }}</td>
    </tr>
</table>
<div>
    <a class="btn btn-danger" href="{{ route('load.find', ['ci' => $load->owner_company_id]) }}">この企業の荷物を検索結果から除外する</a>
</div>
