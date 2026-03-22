<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
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
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'integer',
    ];

    /**
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    /**
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
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
