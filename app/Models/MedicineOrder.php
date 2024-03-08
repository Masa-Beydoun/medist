<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineOrder extends Model
{
    use HasFactory;
    protected $fillable = ['medicine_id','dose_id', 'quantity', 'price'];

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

    public function dose() {
        return $this->belongsTo(MedicineDetails::class);
    }
}
