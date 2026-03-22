<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * コメントの保存処理
     */
    public function store(CommentRequest $request)
    {
        Comment::create([
            'item_id' => $request->item_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('message', 'コメントを投稿しました');
    }
}
