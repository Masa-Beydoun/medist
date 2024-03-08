<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city', 'street', 'region'];
    protected $guarded = ['address_type', 'address_id'];


    public function address() {
        return $this->morphTo();
    }
}
