
<form action="{{ route('public.record') }}" method="POST">
    @csrf
    <table>
        <tr>
            <th>担当者名</th>
            <td><input type="text" name="user_name" value="{{ old('user_name') }}"></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><input type="email" name="user_email" value="{{ old('user_email') }}"></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td><input type="password" name="user_password"></td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td><input type="text" name="company_tel" value="{{ old('company_tel') }}"></td>
        </tr>
        <tr>
            <th>FAX番号</th>
            <td><input type="text" name="company_fax" value="{{ old('company_fax') }}"></td>
        </tr>
        <tr>
            <th>法人名・営業所名</th>
            <td><input type="text" name="company_name" value="{{ old('company_name') }}"></td>
        </tr>
        <tr>
            <th>郵便番号</th>
            <td><input type="text" name="zipcode" value="{{ old('zipcode') }}"></td>
        </tr>
        <tr>
            <th>都道府県</th>
            <td>
                <select name="prefecture_id">
                    <option value=""></option>
                    @foreach ($prefectures as $pref)
                        <option value="{{ $pref->id }}" @if($pref->id == old('prefecture_id')) selected @endif>{{ $pref->name }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <th>市区町村</th>
            <td><input type="text" name="address_1" value="{{ old('address_1') }}"></td>
        </tr>
        <tr>
            <th>番地・建物名</th>
            <td><input type="text" name="address_2" value="{{ old('address_2') }}"></td>
        </tr>
        <tr>
            <th>トラック所有台数</th>
            <td>
                <input type="number" name="truck_count" value="{{ old('truck_count') }}">
                <span>台</span>
            </td>
        </tr>
        <tr>
            <th>紹介者</th>
            <td><input type="text" name="introducer_name" value="{{ old('introducer_name') }}"></td>
        </tr>
        <tr>
            <th>ホームページアドレス</th>
            <td><input type="text" name="company_web_url" value="{{ old('company_web_url') }}"></td>
        </tr>
    </table>

    <button>同意して登録する</button>
</form>