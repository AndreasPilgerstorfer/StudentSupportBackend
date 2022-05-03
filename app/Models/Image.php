<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url'];

    // one image has many courses
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    // one image has many offers
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    // one image has many users
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
