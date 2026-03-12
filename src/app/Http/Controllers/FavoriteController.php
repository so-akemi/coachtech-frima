<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request, $item_id)
    {
    $user_id = Auth::id();
    $favorite = Favorite::where('item_id', $item_id)->where('user_id', $user_id)->first();

    if ($favorite) {
        $favorite->delete(); // すでにあれば削除（白抜きへ）
    } else {
        Favorite::create(['item_id' => $item_id, 'user_id' => $user_id]); // なければ作成（ピンクへ）
    }

    return back();
    }
}
