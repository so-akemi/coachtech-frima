<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    /**
     * 出品画面の表示
     */
    public function create()
    {
        // カテゴリー一覧を取得
        $categories = Category::all();

        return view('items.create', compact('categories'));
    }

    /**
     * 出品商品の保存処理
     */
    public function store(ExhibitionRequest $request)
    {
        // 画像の保存（storage/app/public/item_images に保存）
        $imagePath = $request->file('image')->store('item_images', 'public');

        // 商品データの作成
        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $imagePath,
            'condition' => $request->condition,
            'brand' => $request->brand,
        ]);

        // カテゴリーの中間テーブルへの紐付け
        if ($request->categories) {
            $item->categories()->attach($request->categories);
        }

        return redirect('/')->with('message', '商品を出品しました');
    }
}