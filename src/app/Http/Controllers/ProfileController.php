<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 現在のタブを取得（デフォルトは 'sell'）
        $currentPage = $request->query('page', 'sell');

        // 1. 最初になんでもいいので「空のコレクション」として初期化しておく
        $sellItems = collect();
        $buyItems = collect();

        // 2. 条件に応じて中身を上書きする
        if ($currentPage === 'buy') {
        $buyItems = \App\Models\Item::whereHas('order', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        } else {
        // 出品した商品の取得
        $sellItems = \App\Models\Item::where('user_id', $user->id)->get();
        }

        // 3. ここで compact に渡す。初期化してあるので必ず変数が存在する。
        return view('profile.index', compact('user', 'sellItems', 'buyItems', 'currentPage'));
    }

    /**
     * プロフィール設定画面（編集画面）の表示
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * プロフィールの更新処理
     */
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        // 画像の処理
        if ($request->hasFile('image')) {
            // 古い画像があれば削除
            if ($user->image_url) {
                Storage::disk('public')->delete($user->image_url);
            }
            $path = $request->file('image')->store('profiles', 'public');
            $user->image_url = $path;
        }

        // データの更新
        $user->update([
            'name' => $request->user_name,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        $user->save();

        // 更新後はトップページ（商品一覧）へ
        return redirect('/')->with('message', 'プロフィールを更新しました');
    }
}
