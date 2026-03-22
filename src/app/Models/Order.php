<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
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
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
