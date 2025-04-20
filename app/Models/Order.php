<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'send_to_kitchen_time',
        'status',
        'total_price'
    ];

    protected $casts = [
        'send_to_kitchen_time' => 'datetime',
    ];

    public function concessions(): BelongsToMany
    {
        return $this->belongsToMany(Concession::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
