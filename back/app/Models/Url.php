<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Url extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = true;

    protected $fillable = [
        'name',
        'url',
        'user_id'
    ];

    protected $appends = ['links_account'];

    protected $with = ['links'];

    public function links(): HasMany
    {
        return $this->hasMany(UrlLinks::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    protected function linksAccount(): Attribute
    {
        return new Attribute(
            get: fn () => $this->links()->count(),
        );
    }
}
