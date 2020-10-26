<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\{Order};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function getAllOrders()
    {
        $orders = Order::all();
        return response() -> json([
            'status' => 1,
            'message' => "List of all orders",
            'data' => [
                'orders' => OrderResource::collection($orders)
            ]
        ], 200);
    }

    
}
