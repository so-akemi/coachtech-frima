<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // 一括代入を許可する項目を指定（これをしないと保存時にエラーになります）
    protected $fillable = [
        'user_id', 
        'name', 
        'price', 
        'brand',       // 追加
        'description', 
        'condition',   // 追加
        'image_url'    // 前回の 'image_path' から変更
    ];

    // 商品は一人のユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 商品・注文は一つの注文に属する
    public function orders()
    {
        return $this->hasOne(Order::class);
    }

    public function categories()
    {
    return $this->belongsToMany(Category::class, 'category_item');
    }

    protected $casts = [
        'price' => 'integer', // priceを整数として扱う
    ];
}
