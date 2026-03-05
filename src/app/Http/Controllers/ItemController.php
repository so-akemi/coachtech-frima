<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index() {
        $items = Item::all();
        //dd($items); // ここでアイテムの内容を確認

        return view('items.index', compact('items'));
    }

    public function show($item_id) {
        $item = Item::findOrFail($item_id);
        return view('items.show', compact('item'));
    }
    
    public function purchase($item_id) {
        $item = Item::findOrFail($item_id);
        // 購入処理をここに実装（例: 在庫の減少、購入履歴の保存など）
        // ここでは簡単に購入完了のメッセージを表示するだけにします
        return view('purchase.index', compact('item'));
    }

    public function editAddress($item_id) {
        $item = Item::findOrFail($item_id);
        return view('purchase.address', compact('item'));
    }

    public function updateAddress(Request $request, $item_id) {
        $item = Item::findOrFail($item_id);
        // ここで住所の更新処理を実装（例: ユーザーの住所情報を保存するなど）
        // 一旦、画面を戻す処理だけ書きます
        return redirect()->route('item.purchase', ['item_id' => $item_id]);
    }
}
