<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // 1. バリデーション（空文字などを防ぐ）
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'content' => 'required|max:255',
        ]);

        // 2. データベースへ保存
        Comment::create([
            'item_id' => $request->item_id,
            'user_id' => Auth::id(), // ログイン中のユーザーID
            'content' => $request->content,
        ]);

        // 3. 元の商品詳細ページへ戻る
        return back()->with('message', 'コメントを投稿しました');
    }
}
