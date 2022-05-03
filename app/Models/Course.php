<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', "image_id", "number"];

    // one course has many offers
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    //one course belongs to one image
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
