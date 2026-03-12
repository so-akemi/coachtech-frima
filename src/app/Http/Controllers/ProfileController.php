<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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
        // 購入した商品の取得（まだ機能がない場合は空のままでOK）
        // $buyItems = ... 
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
    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:8'],
            'address'     => ['required', 'string', 'max:255'],
            'building'    => ['nullable', 'string', 'max:255'],
        ]);

        // データの更新
        $user->update([
            'name'        => $request->name,
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ]);

        // 更新後はトップページ（商品一覧）へ
        return redirect('/')->with('message', 'プロフィールを更新しました');
    }
}
