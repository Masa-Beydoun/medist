<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoseResource;
use App\Models\MedicineDetails;
use App\Models\Order;
use http\Env\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class NotificationController extends BaseController

{
    public function confirmOrder(Request $request){

        try {
            $SERVER_API_KEY = 'BH3N1m6Up-Yf7ZL3EinOZCC5emQ13hatnFRiQwhLMs-1fQbSewI4xgxvuklYj3QoAPpHpwhg1PDomcM3uOkNvm4';
            $token_1 = $request->input('token');
            $order_id=$request->input('order_id');
            //$pharmacist_id=$request->input('$pharmacist_id');


            $order = Order::find($order_id);
            if(!$order) {
                return response()->json([
                    'message' => 'Medicine Not Found',
                ],404);
            }
            $order->status='Preparing';
            $order->quantity->save();


            $data = [
                "registration_ids" => [
                    $token_1
                ],
                "notification" => [
                    "title" => "Medist",
                    "body" => "Your Order has been accepted successfully",
                    "sound" => "default"
                ]
            ];
            $dataString = json_encode($data);
            $headers = [
                'Authorization keys' . $SERVER_API_KEY,
                'content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($ch);
        }
        catch (Exception) {}

        return respone()->json([
            'message' => 'Preparing'
        ],200);
    }
}
