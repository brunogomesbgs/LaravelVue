<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'transit_deposit',
        'status',
        'user_id'
    ];

    protected $attributes = [
        'transit_deposit' => 0,
        'current_deposit' => 0,
        'status' => false
    ];

    public function users(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
