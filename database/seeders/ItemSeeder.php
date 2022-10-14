<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => 'ステーキ',
                'user_id' => rand(1, User::count()),
                'price' => '680',
                'allergy' => '塩胡椒',
                'introduction' => '美味しい',
                'status' => '販売中',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ハンバーグ',
                'user_id' => rand(1, User::count()),
                'price' => '880',
                'allergy' => 'デミグラス',
                'introduction' => '美味しい',
                'status' => '販売停止',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'サバ焼き',
                'user_id' => rand(1, User::count()),
                'price' => '880',
                'allergy' => '魚',
                'introduction' => '美味しい',
                'status' => '販売中',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '味噌炒め',
                'user_id' => rand(1, User::count()),
                'price' => '550',
                'allergy' => 'デミグラス',
                'introduction' => '美味しい',
                'status' => '販売中',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'みぞれかつ',
                'user_id' => rand(1, User::count()),
                'price' => '680',
                'allergy' => 'チーズ',
                'introduction' => '美味しい',
                'status' => '販売停止',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
