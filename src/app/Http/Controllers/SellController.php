<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    /// ItemController.php もしくは SellController.php

    public function create()
    {
        // カテゴリー一覧を取得（もしテーブルがある場合）
        $categories = \App\Models\Category::all();

        // 第二引数で確実にビューへ渡す
        return view('items.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        // 画像の保存（storage/app/public/item_images に保存）
        $imagePath = $request->file('image')->store('item_images', 'public');

        // DB保存
        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $imagePath,
            'condition' => $request->condition,
            'brand' => $request->brand,
        ]);

        // 2. $item が定義されたので、これで attach が動くようになります
        $item->categories()->attach($request->categories);

        return redirect('/')->with('message', '商品を出品しました');
    }
}
