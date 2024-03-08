<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseLoginRequest;
use App\Http\Resources\WarehouseResource;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(WarehouseLoginRequest $request)
    {
        $warehouseData = $request->validated();
        $warehouse = Warehouse::where('username', $warehouseData['username'])->first();
        if (!$warehouse || !Hash::check($warehouseData['password'], $warehouse->password)) {
            return response([
                'msg' => 'Invalid Credentials'
            ], 422);
        }
        $token = $warehouse->createToken('company')->plainTextToken;
        return response([
            'warehouse' => $warehouse->name,
            //count
            'token' => $token
        ], 200);
    }

    public function logout()
    {
        $warehouse = Warehouse::find(Auth::guard('sanctum')->user()->id);
        $warehouse->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'],200);
    }
}
