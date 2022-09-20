<div>
    <div>
        <div>
            <span>荷物番号</span>
            <span>{{ $load->id }}</span>
        </div>
    </div>
    <div>
        <div>
            <p>{{ $load->getDepartureAt("load_show") }}</p>
            <p>{{ $load->getDepartureAddress() }}</p>
        </div>
        <div>
            <p>{{ $load->getArrivalAt("load_show") }}</p>
            <p>{{ $load->getArrivalAddress() }}</p>
        </div>
        <div>
            <span>{{ number_format($load->fare_amount) }}</span>
            <span>高速代{{ $load->is_highway_fare ? "あり" : "なし"}}</span>
        </div>
    </div>
    <table>
        <tr>
            <th>企業名</th>
            <td>
                <p>{{ $load->owner->getCompanyAndOfficeName() }}</p>
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
</div>