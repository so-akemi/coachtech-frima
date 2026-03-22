<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Favorite;
use App\Models\Category;
use App\Models\Comment;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seller = User::factory()->create([
            'name'  => '出品者ユーザー',
            'email' => 'seller@example.com',
        ]);

        $buyer = User::where('email', 'test123@example.com')->first();
        if ($buyer) {
            $buyer->update([
                'postal_code' => null,
                'address'     => null,
                'building'    => null,
            ]);
        }

        $items = [
            ["name" => "腕時計", "price" => 15000, "brand" => "Rolax", "description" => "スタイリッシュなデザインのメンズ腕時計", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg", "condition" => "良好"],
            ["name" => "HDD", "price" => 5000, "brand" => "西芝", "description" => "高速で信頼性の高いハードディスク", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg", "condition" => "目立った傷や汚れなし"],
            ["name" => "玉ねぎ3束", "price" => 300, "brand" => "なし", "description" => "新鮮な玉ねぎの3束セット", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg", "condition" => "やや傷や汚れあり"],
            ["name" => "革靴", "price" => 4000, "brand" => null, "description" => "クラシックなデザインの革靴", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg", "condition" => "状態が悪い"],
            ["name" => "ノートPC", "price" => 45000, "brand" => null, "description" => "高性能なノートパソコン", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg", "condition" => "良好"],
            ["name" => "マイク", "price" => 8000, "brand" => "なし", "description" => "高音質のレコーディング用マイク", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg", "condition" => "目立った傷や汚れなし"],
            ["name" => "ショルダーバッグ", "price" => 3500, "brand" => null, "description" => "おしゃれなショルダーバッグです。", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg", "condition" => "やや傷や汚れあり"],
            ["name" => "タンブラー", "price" => 500, "brand" => "なし", "description" => "使いやすいタンブラーです。", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg", "condition" => "状態が悪い"],
            ["name" => "コーヒーミル", "price" => 4000, "brand" => "Starbucks", "description" => "手動のコーヒーミルです。", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg", "condition" => "良好"],
            ["name" => "メイクセット", "price" => 2500, "brand" => null, "description" => "便利なメイクアップセットです。", "image_url" => "https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg", "condition" => "目立った傷や汚れなし"],
        ];

        foreach ($items as $item) {
            $currentSellerId = ($item['name'] === "メイクセット") ? $buyer->id : $seller->id;

            $newItem = Item::create([
                "user_id"     => $currentSellerId,
                "name"        => $item["name"],
                "price"       => $item["price"],
                "brand"       => $item["brand"],
                "description" => $item["description"],
                "image_url"   => $item["image_url"],
                "condition"   => $item["condition"],
            ]);

            if ($newItem->name === "腕時計" && $buyer) {
                Order::create([
                    'user_id'     => $buyer->id,
                    'item_id'     => $newItem->id,
                    'postal_code' => '123-4567',
                    'address'     => '東京都渋谷区テスト123',
                    'building'    => ' ',
                ]);
            }

            if (in_array($newItem->name, ["腕時計", "玉ねぎ3束"]) && $buyer) {
                Favorite::create([
                    'user_id' => $buyer->id,
                    'item_id' => $newItem->id,
                ]);
            }
        }

        $targetItem = Item::first();
        $commentUser = User::where('id', '!=', $targetItem->user_id)->first();

        if ($targetItem && $commentUser) {
            Comment::create([
                'item_id' => $targetItem->id,
                'user_id' => $commentUser->id,
                'content' => 'この商品の状態を詳しく教えてください！'
            ]);
        }

        $categories = Category::take(2)->get();
        if ($targetItem && $categories->count() >= 2) {
            $targetItem->categories()->attach($categories->pluck('id'));
        }
    }
}
