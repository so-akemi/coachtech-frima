<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
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
