<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\{Order, CompleteOrder, Status, Message};
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

    public function DeleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response() -> json([
            'status' => 1,
            'message' => 'Order deleted successfully'
        ], 200);    
    }

    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);

        // insert record in complete orders table
        $completeOrder = new CompleteOrder;
        $completeOrder->insertRecord($order);

        // Add record to messages table
        // Add record to messages table
        $this->addRecordToMessagesTable($order->order_no, $order->delivery_customer, 'finished', $order->buyer_phone);

        // $messageRecord = [
        //     'order_no' => $order->order_no,
        //     'name' =>  $order->delivery_customer,
        //     'type' => 'finished',
        //     'phone_number' => $order->buyer_phone
        // ];

        // $message = new Message;
        // $message->insertRecord($messageRecord);

        // remove order from orders table
        $order->delete();

        return response() -> json([
            'status' => 1,
            'message' => "Order inserted successfully",
        ], 200);
    }

    public function updateOrderStatus($id, Request $request)
    {
        $order = Order::findOrFail($id);

        // Add record to messages table
        $this->addRecordToMessagesTable($order->order_no, $order->delivery_customer, $request->statusName, $order->buyer_phone);

        // If Status is finished then move record to completed_orders table
        // And then remove record from orders table
        if($request->statusName == 'finished') {
            $completeOrder = new CompleteOrder;
            $completeOrder->insertRecord($order);   
            
            $order->delete();
        
        } else {
            $statusId = Status::where('name', '=', $request->statusName)->pluck('id')->first();
            $order->statuses_id = $statusId;
            $order->save();
        }

        return response() -> json([
            'status' => 1,
            'message' => "Order status has been updated successfully",
        ], 200);

    }


    private function addRecordToMessagesTable($order_no, $delivery_customer, $type, $phone_number)
    {
        $record = [
            'order_no' => $order_no,
            'name' =>  $delivery_customer,
            'type' => $type,
            'phone_number' => $phone_number
        ];

        $message = new Message;
        $message->insertRecord($record);

        return;
    }

    
}
