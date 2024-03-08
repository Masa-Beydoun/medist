<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Warehouse extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['name', 'username'];
    protected $hidden = ['password'];

    public function companies() {
        return $this->belongsToMany(Company::class);
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
