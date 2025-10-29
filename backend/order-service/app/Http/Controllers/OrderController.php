<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RabbitMQService;

class OrderController extends Controller
{
    protected $rabbit;

    public function __construct(RabbitMQService $rabbit)
    {
        $this->rabbit = $rabbit;
    }

    public function createOrder(Request $request)
    {
        $orderData = [
            'id' => rand(1000, 9999),
            'product' => $request->input('product', 'Sample Product'),
            'quantity' => $request->input('quantity', 1),
        ];

        $this->rabbit->publish($orderData);

        return response()->json([
            'message' => 'Order placed & sent to RabbitMQ!',
            'order' => $orderData
        ]);
    }
}
