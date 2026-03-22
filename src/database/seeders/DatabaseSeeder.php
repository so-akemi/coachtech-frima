<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,           // 1. まずユーザーを作成
            CategoriesTableSeeder::class, // 2. 次にマスターデータ（カテゴリー）を作成
            ItemSeeder::class,           // 3. 最後にユーザーとカテゴリーを紐付けた商品を作成
        ]);
    }
}