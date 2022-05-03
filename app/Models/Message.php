<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['offer_id', 'user_id', 'title', 'text'];

    //one message belongs to one offer
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    //one message belongs to one user (student)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
