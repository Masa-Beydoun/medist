<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacistDataRequest;
use App\Http\Resources\PharmacistProfileResource;
use Illuminate\Support\Facades\Auth;

class PharmacistController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function showDetails()
    {
        $pharmacist = Auth::guard('sanctum')->user();
        return response()->json([
            'pharmacist' => new PharmacistProfileResource($pharmacist)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateData(PharmacistDataRequest $request)
    {
        $pharmacist = Auth::guard('sanctum')->user();
        $updatedData = $request->validated();
        // $pharmacistData = [$updatedData['password'],$updatedData['phone_number']];
        // $pharmacist->password = $updatedData['password'];
        $pharmacist->phone_number = $updatedData['phone_number'];
        $pharmacist->save();
        //-------
        $address = $pharmacist->address;
        if(!$address) {
            $address = $pharmacist->address()->create($request->only('city', 'name', 'region', 'street'));
        } else {
            $address->name = $updatedData['name'];
            $address->city = $updatedData['city'];
            $address->region = $updatedData['region'];
            $address->street = $updatedData['street'];
            $address->save();
            $pharmacist->address()->save($address);
        }
        $pharmacist->save();
        return response()->json([
            'message' => 'Updated Successfully',
            'pharmacist' => new PharmacistProfileResource($pharmacist),
        ],200);
    }


}
