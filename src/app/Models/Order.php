<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'item_id',
        'postal_code',
        'address',
        'building',
    ];

    /**
     * 注文したユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 注文された商品を取得
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}