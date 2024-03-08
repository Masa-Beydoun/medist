<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineResource;
use App\Models\MedicineDetails;
use App\Models\Quantity;

class QuantityController extends Controller
{
    // public function mostSold() {
    //     $quantities = Quantity::all()->sortByDesc('sold')->take(10);
    //     foreach($quantities as $quantity) {
    //         $doses[] = MedicineDetails::find($quantity->medicine_details_id)->medicine;
    //     }
    //     return response()->json([
    //         'message' => 'Most Common Retrieved Successfully',
    //         'medicine' => MedicineResource::collection($doses),
    //     ]);
    // }
    public function mostSold() {
        $quantities = Quantity::where('warehouse_id', request()->warehouse_id)->get()->sortByDesc('sold')->take(10);
        $doses = [];
        foreach($quantities as $quantity) {
            $doses[] = MedicineDetails::find($quantity->medicine_details_id)->medicine;
        }
        $doses = array_unique($doses);
        return response()->json([
            'message' => 'Most Common Retrieved Successfully',
            'medicine' => MedicineResource::collection($doses),
        ],200);
    }
}
