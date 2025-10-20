<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->delete(); // truncate の代わり

        DB::table('posts')->insert([
            [
                'user_id' => 3,
                'post_title' => '今日の天気',
                'post' => '降水確率50%',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ]);
    }
}
