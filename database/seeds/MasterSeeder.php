<?php

use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 都道府県
        $prefectures = [
            "北海道",
            "青森県",
            "岩手県",
            "宮城県",
            "秋田県",
            "山形県",
            "福島県",
            "茨城県",
            "栃木県",
            "群馬県",
            "埼玉県",
            "千葉県",
            "東京都",
            "神奈川県",
            "新潟県",
            "富山県",
            "石川県",
            "福井県",
            "山梨県",
            "長野県",
            "岐阜県",
            "静岡県",
            "愛知県",
            "三重県",
            "滋賀県",
            "京都府",
            "大阪府",
            "兵庫県",
            "奈良県",
            "和歌山県",
            "鳥取県",
            "島根県",
            "岡山県",
            "広島県",
            "山口県",
            "徳島県",
            "香川県",
            "愛媛県",
            "高知県",
            "福岡県",
            "佐賀県",
            "長崎県",
            "熊本県",
            "大分県",
            "宮崎県",
            "鹿児島県",
            "沖縄県",
        ];
        foreach($prefectures as $pref_name) {
            DB::table("prefectures")->insert([
                "name" => $pref_name,
            ]);
        }

        // 従業員数
        $employee_sizes = [
            "1～10人",
            "11人～20人",
            "21人～50人",
            "51人～100人",
            "101人以上",
        ];
        foreach($employee_sizes as $size_name) {
            DB::table("employee_sizes")->insert([
                "name" => $size_name,
            ]);
        }

        // ユーザーの役職
        $user_roles = [
            "役員",
            "配車担当",
        ];
        foreach($user_roles as $role_name) {
            DB::table("user_roles")->insert([
                "name" => $role_name,
            ]);
        }

        // トラック重量
        $capacity_types = [
            "軽",
            "1t",
            "2t",
            "3t",
            "4t",
            "5t",
            "6t",
            "7t",
            "8t",
            "9t",
            "10t",
            "11t",
            "12t",
            "13t",
            "14t",
            "15t",
            "トレーラー",
            "他",
        ];
        foreach($capacity_types as $type_name) {
            DB::table("truck_capacity_types")->insert([
                "name" => $type_name,
            ]);
        }

        // トラック荷台
        $cargo_types = [
            "平",
            "平-低床",
            "平-パワーゲート",
            "平-エアサス",
            "箱",
            "箱-低床",
            "箱-パワーゲート",
            "箱-エアサス",
            "ウイング",
            "ウイング-低床",
            "ウイング-パワーゲート",
            "ウイング-エアサス",
            "ユニック",
            "冷凍",
            "保冷",
            "他",
            "ウイング又は平",
            "ウイング又は箱",
        ];
        foreach($cargo_types as $type_name) {
            DB::table("truck_cargo_types")->insert([
                "name" => $type_name,
            ]);
        }

        // ドライバー作業
        $driver_works = [
            "フォーク",
            "クレーン",
            "手作業",
            "なし",
        ];
        foreach($driver_works as $work) {
            DB::table("driver_works")->insert([
                "name" => $work,
            ]);
        }
    }
}
