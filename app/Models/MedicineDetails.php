<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineDetails extends Model
{
    use HasFactory;
    protected $fillable = ['dose', 'type', 'price', 'expiry_date'];

    public function quantity() {
        return $this->hasOne(Quantity::class);
    }

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

}
