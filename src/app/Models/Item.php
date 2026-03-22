<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'price',
        'brand',
        'description',
        'condition',
        'image_url',
    ];

    /**
     * 属性のキャスト設定
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'integer',
    ];

    /**
     * 商品を所有するユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 商品に関連付けられた注文を取得（1対1）
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * 商品に紐付くカテゴリーを取得（多対多）
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    /**
     * 商品に対するお気に入り一覧を取得
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * 商品に対するコメント一覧を取得
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 特定のユーザーがこの商品をお気に入り登録済みか判定
     *
     * @param  \App\Models\User|null  $user
     * @return bool
     */
    public function isFavoritedBy($user)
    {
        if (!$user) {
            return false;
        }

        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}