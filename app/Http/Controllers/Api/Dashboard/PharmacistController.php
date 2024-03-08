<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\PharmacistResource;
use App\Models\Pharmacist;
use Illuminate\Http\Request;

class PharmacistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacists = Pharmacist::all();
        return response()->json([
            'pharmacists' => PharmacistResource::collection($pharmacists)
        ],200);
    }}
