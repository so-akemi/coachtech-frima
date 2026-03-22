<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'postal_code',
        'address',
        'building',
        'avatar_path',
        'introduction',
    ];

    /**
     * シリアライズ時に隠蔽する属性
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 属性のキャスト設定
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ユーザーが所有する商品一覧を取得（出品）
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * ユーザーが行った注文一覧を取得
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * ユーザーがお気に入り登録した商品一覧を取得（多対多）
     */
    public function favoriteItems()
    {
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id')->withTimestamps();
    }

    /**
     * ユーザーが投稿したコメント一覧を取得
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}