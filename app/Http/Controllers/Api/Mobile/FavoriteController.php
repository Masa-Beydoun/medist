<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineResource;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addFavorites(Request $request)
    {
        $pharmacist = Auth::guard('sanctum')->user();
        $medicine = Medicine::find($request->id);
        if(!$medicine) {
            return response()->json([
                'message' => 'Medicine Doesnt Exist'
            ],404);
        }
        $pharmacist->favorites()->syncWithoutDetaching($medicine); ////
        return response()->json([
            'message' => 'Added To Favorites Successfully',
        ],200);
    }

    public function getFavorites(Request $request)
    {
        $pharmacist = Auth::guard('sanctum')->user();
        $favorites = $pharmacist->favorites->where('warehouse_id', $request->warehouse_id);
        if(sizeof($favorites) == 0) {
            return response()->json([
                'message' => 'No Favorites Found',
            ],404);
        }
        return response()->json([
            'message' => 'Retrieved All Favorites Successfully',
            'count' => count($favorites),
            'favorites' => MedicineResource::collection($favorites)
        ],200);
    }

    public function removeFromFavorites(string $id)
    {
        $pharmacist = Auth::guard('sanctum')->user();
        $medicine = Medicine::find($id);
        $pharmacist->favorites()->detach($medicine);
        return response()->json([
            'message' => 'Removed From Favorites Successfully',
        ],200);
    }
}
