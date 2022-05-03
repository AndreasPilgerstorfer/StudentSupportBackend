<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    use HasFactory;

    protected $fillable = ['offer_id', 'user_id', 'state'];

    //one request belongs to one user (student)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //one request belongs to one offer
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }
}
