<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pharmacist extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'phone_number'];
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    // This is to bcyrpt password but found that [$casts] work the same way
    // public function setPasswordAttribute($value) {
    //     $this->attributes['password'] = bcrypt($value);
    //  }

    public function address() {
        return $this->morphOne(Address::class, 'address');
    }

    public function setting() {
        return $this->hasOne(Setting::class);
    }

    public function favorites() {
        return $this->belongsToMany(Medicine::class, 'favorites');
    }

    public function orders() {
        return $this->hasMany(Order::class)->orderByDesc('created_at');
    }

    public function latestOrder() {
        return $this->hasOne(Order::class)->orderByDesc('created_at');
    }
}
