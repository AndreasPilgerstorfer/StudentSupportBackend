<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'user_id', 'start_time',
        'end_time', 'date', 'title', 'description', 'state', 'image_id',
        'associatedStudent'];

    //one Offer belongs to one course
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    //one offer belongs to one user (teacher)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // one offer has many requests
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    // one offer has many messages
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    //one offer belongs to one image
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
