<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrlLinks extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = ['id'];

    protected $fillable = [
        'url_id',
        'name',
        'link'
    ];

    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
