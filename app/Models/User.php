<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = ['firstname', 'lastname', 'password',
        'phone_number', 'email', 'image_id', 'education', 'is_student'];

    // one user has many offers
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    // one user (student) has many requests
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    // one user has many messages
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    //one user belongs to one image
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function getJWTIdentifier()
    {
        //Primary Key
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        //das was man mitsenden möchte (auch mehrere Rollen möglich)
        return ['user' => ['id'=>$this->id, 'is_student'=>$this->is_student]];
    }

}
