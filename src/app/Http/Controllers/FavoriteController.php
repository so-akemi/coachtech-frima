<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    /**
     * お気に入りの登録・解除を切り替える
     */
    public function toggle(Request $request, $item_id)
    {
        $user_id = Auth::id();

        // 既にお気に入り登録されているか確認
        $favorite = Favorite::where('item_id', $item_id)
            ->where('user_id', $user_id)
            ->first();

        if ($favorite) {
            // すでにあれば削除（お気に入り解除）
            $favorite->delete();
        } else {
            // なければ作成（お気に入り登録）
            Favorite::create([
                'item_id' => $item_id, 
                'user_id' => $user_id
            ]);
        }

        return back();
    }
}