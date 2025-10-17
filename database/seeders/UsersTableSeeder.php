<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 DB::table('users')->insert([
            [
                'over_name' => 'テスト',
                'under_name' => 'タロウ',
                'over_name_kana' => 'テスト',
                'under_name_kana' => 'タロウ',
                'mail_address' => 'test1@example.com',
                'sex' => 1, // 例: 1=男性, 2=女性など
                'birth_day' => '1990-01-01',
                'role' => 1, // 例: 1=一般ユーザー, 2=管理者など
                'password' => Hash::make('password111'),
                'remember_token' => Str::random(10),
            ],
            [
                'over_name' => 'テスト花子',
                'under_name' => 'ハナコ',
                'over_name_kana' => 'テスト',
                'under_name_kana' => 'ハナコ',
                'mail_address' => 'test2@example.com',
                'sex' => 2,
                'birth_day' => '1995-05-15',
                'role' => 1,
                'password' => Hash::make('password222'),
                'remember_token' => Str::random(10),
            ],
        ]);
    }
}
