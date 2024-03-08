<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d'
    // ];

    protected function scopeBetweenDates($query, array $dates) {
        return $query->whereDate('created_at', '>=' ,$dates[0])
                    ->whereDate('created_at', '<=' ,$dates[1]);
    }

    public function medicines() {
        return $this->hasMany(MedicineOrder::class);
    }
}
