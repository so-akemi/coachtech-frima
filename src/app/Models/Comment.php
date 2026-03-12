<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // マスアサインメント対策（保存を許可するカラム）
    protected $fillable = ['item_id', 'user_id', 'content'];

    // このコメントを投稿したユーザーを取得
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // このコメントが紐付いている商品を取得
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
