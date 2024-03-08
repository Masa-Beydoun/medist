<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardOrderDetailsResource;
use App\Http\Resources\DashboardOrderResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request) {
        $status = [
            'pending' => 'Pending',
            'being-prepared' => 'Being Prepared',
            'on-the-way' => 'On The Way',
            'delivered' => 'Delivered',
            'rejected' => 'Rejected',
        ];

        $warehouse = auth()->guard('sanctum')->user();
        $orders = $warehouse->orders;
        if($request->filter){
            $orders = $warehouse->orders->where('status', $status[$request->filter]);
        }
        if(sizeof($orders) == 0) {
            return response()->json([
                'message' => 'No Orders Found',
            ],404);
        }
        return response()->json([
            'message' => 'Orders Retrieved',
            'count' => count($orders),
            'orders' => DashboardOrderResource::collection($orders)
        ]);
    }

    public function show(Order $order) {
        return response()->json([
            'message' => 'Order Retrieved',
            'orders' => new DashboardOrderDetailsResource($order)
        ]);
    }

    public function changeStatus(Request $request, Order $order){
        $order->status = $request->status;
        // 1 for being prepared (default)
        // 2 for sent
        // 3 for delivered
        $order->save();
        return response()->json([
            'message' => 'Status Updated'
        ],200);
    }

    public function changePaymentStatus(Request $request, Order $order){
        $order->payment_status = $request->payment_status;
        // 0 for not paid
        // 1 for paid
        $order->save();
        return response()->json([
            'message' => 'Payment Status Updated'
        ],200);
    }

    public function changeOrderStatus(Request $request, Order $order){
        $order->is_accepted = $request->is_accepted;
        // 0 for rejected
        // 1 for accepted
        if($order->status == 1) {
            foreach($order->medicines as $medicine) {
                $medicine->dose->quantity->available -= $medicine->quantity;
                $medicine->dose->quantity->sold += $medicine->quantity;
                $medicine->dose->quantity->save();
            }
            $order->status = 'Being Prepared';
            $order->save();
            return response()->json([
                'message' => 'Order Accepted'
            ],200);
        }
        $order->save();
        return response()->json([
            'message' => 'Order Rejected'
        ],400);
    }

    public function checkPossibility(Order $order){
        $possible = [];
        $check = true;
        foreach($order->medicines as $medicine) {
            if($medicine->quantity > $medicine->dose->quantity->available) {
                $possible[] = true;
            }
            else {
                $possible[] = false;
                $check = false;
            }
        }
        if($check) {
            return response()->json([
                'message' => 'Order Can Be Accepted',
                'possibility' => $possible
            ],200);
        }
        return response()->json([
            'message' => 'Order Cant Be Accepted',
            'possibility' => $possible
        ],400);
    }

    public function rejectedOrders() {
        $warehouse = auth()->guard('sanctum')->user();
        $orders = $warehouse->orders->where('is_accepted', 0);
        if(sizeof($orders) == 0) {
            return response()->json([
                'message' => 'No Rejected Orders Found',
            ],404);
        }
        return response()->json([
            'message' => 'Rejected Orders Retrieved',
            'count' => count($orders),
            'orders' => OrderResource::collection($orders)
        ]);
    }
}
