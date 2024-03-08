<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function updateData(Request $request)
    {
        $pharmacist = Auth::guard('sanctum')->user();
        $updatedData = $request->all();
        $address = $pharmacist->address;
        if(!$address) {
            if(!$request->name || !$request->city || !$request->street) {
                return response()->json([
                    'message' => 'Fields Required',
                ],400);
            }
            $pharmacist->address()->create($updatedData);
        } else {
            $address->update($updatedData);
            $pharmacist->address()->save($address);
        }
        return response()->json([
            'message' => 'Address Updated Successfully',
        ],200);
    }
}
    // ------------------------
