<h5>基本情報</h5>
<table class="table">
    <tr>
        <th>法人名・事業者名</th>
        <td>
            <p>{{ $company->name_hiragana }}</p>
            <p>{{ $company->name }}</p>
            <a href="{{ route('load.find', ['co' => $company->id]) }}">この企業の他の荷物をみる</a>
        </td>
    </tr>
    <tr>
        <th>住所</th>
        <td>
            <p>〒{{ $company->zipcode }}</p>
            <p>{{ $company->getFullAddress() }}</p>
        </td>
    </tr>
    <tr>
        <th>電話番号</th>
        <td>{{ $company->tel }}</td>
    </tr>
    <tr>
        <th>FAX番号</th>
        <td>{{ $company->fax }}</td>
    </tr>
    <tr>
        <th>事業内容・会社PR</th>
        <td>{!! nl2br(e($company->business_content)) !!}</td>
    </tr>
    <tr>
        <th>保有車両台数</th>
        <td>{{ $company->truck_count }}台</td>
    </tr>
    <tr>
        <th>ウェブサイトURL</th>
        <td><a href="{{ $company->company_web_url }}">{{ $company->company_web_url }}</a></td>
    </tr>
    <tr>
        <th>登録年月</th>
        <td>{{ $company->created_at->format("Y年n月") }}</td>
    </tr>
    <tr>
        <th>直近1ヶ月<br>荷物登録数</th>
        <td>-</td>
    </tr>
    <tr>
        <th>直近3ヶ月<br>荷物登録数</th>
        <td>-</td>
    </tr>
    <tr>
        <th>直近1ヶ月<br>車両登録数</th>
        <td>-</td>
    </tr>
    <tr>
        <th>直近3ヶ月<br>車両登録数</th>
        <td>-</td>
    </tr>
</table>

<h5>詳細情報</h5>
<table class="table">
    <tr>
        <th>代表者</th>
        <td>{{ $company->representative_name ?? "-" }}</td>
    </tr>
    <tr>
        <th>設立</th>
        <td>{{ $company->established_at ? $company->established_at->format("Y年n月") : "-" }}</td>
    </tr>
    <tr>
        <th>資本金</th>
        <td>{{ $company->capital_amount ?? "-" }}<span>万円</span></td>
    </tr>
    <tr>
        <th>従業員数</th>
        <td>{{ $company->employee_size ? $company->employee_size->name : "-" }}</td>
    </tr>
    <tr>
        <th>事業所所在地</th>
        <td>{{ $company->office_address ?? "-" }}</td>
    </tr>
    <tr>
        <th>年間売上</th>
        <td>{{ $company->sales_amount ?? "-" }}<span>万円</span></td>
    </tr>
    <tr>
        <th>取引先銀行</th>
        <td>{{ $company->bank_name ?? "-" }}</td>
    </tr>
    <tr>
        <th>主要取引先</th>
        <td>{{ $company->main_trading_partner_name ?? "-" }}</td>
    </tr>
    <tr>
        <th>締め日</th>
        <td>{{ $company->cut_off_day ?? "-" }}</td>
    </tr>
    <tr>
        <th>支払月・支払日</th>
        <td>{{ "-" }}</td>
    </tr>
    <tr>
        <th>加入組織</th>
        <td>{{ $company->union_name ?? "-" }}</td>
    </tr>
    <tr>
        <th>国交省認可番号</th>
        <td>{{ $company->government_license_number ?? "-" }}</td>
    </tr>
    <tr>
        <th>営業地域</th>
        <td>{{ $company->business_area_name ?? "-" }}</td>
    </tr>
    <tr>
        <th>デジタコ搭載数</th>
        <td>{{ $company->digi_tacho_count ?? "-" }}<span>台</span></td>
    </tr>
    <tr>
        <th>GPS搭載数</th>
        <td>{{ $company->gps_count ?? "-" }}<span>台</span></td>
    </tr>
    <tr>
        <th>安全性優良事業所認定</th>
        <td>{{ $company->has_safety_cert ? "有" : "無" }}</td>
    </tr>
    <tr>
        <th>グリーン経営認証</th>
        <td>{{ $company->has_green_cert ? "有" : "無" }}</td>
    </tr>
    <tr>
        <th>ISO9000</th>
        <td>{{ $company->has_iso9000 ? "有" : "無" }}</td>
    </tr>
    <tr>
        <th>ISO14000</th>
        <td>{{ $company->has_iso14000 ? "有" : "無" }}</td>
    </tr>
    <tr>
        <th>ISO39001</th>
        <td>{{ $company->has_iso39001 ? "有" : "無" }}</td>
    </tr>
    <tr>
        <th>保険会社名</th>
        <td>{{ $company->insurance_company_name }}</td>
    </tr>
</table>