<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        // コレクションの初期化
        $sellItems = collect();
        $buyItems = collect();

        // 表示モードに応じたデータ取得
        if ($currentPage === 'buy') {
            $buyItems = Item::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $sellItems = Item::where('user_id', $user->id)->get();
        }

        return view('profile.index', compact('user', 'sellItems', 'buyItems', 'currentPage'));
    }

    /**
     * プロフィール設定画面（編集画面）の表示
     */
    public function edit()
    {
        $user = auth()->user();

        // 未認証ユーザーのガード
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * プロフィールの更新処理
     */
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        // 画像の保存処理
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

        return redirect('/')->with('message', 'プロフィールを更新しました');
    }
}