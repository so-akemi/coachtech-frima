<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * このカテゴリーに属する商品を取得
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'category_item');
    }
}