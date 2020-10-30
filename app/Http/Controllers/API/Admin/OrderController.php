<?php

namespace App\Http\Controllers\API\Admin;

use DB;
use App\Models\{Order, CompleteOrder, Status, Message};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{OrderResource};

class OrderController extends Controller
{
    public function getAllOrders()
    {
        $statusId = $this->getStatusId('finished');
        $orders = Order::where('statuses_id', '!=', $statusId)->get();

        return response() -> json([
            'status' => 1,
            'message' => "List of all orders",
            'data' => [
                'orders' => OrderResource::collection($orders)
            ]
        ], 200);
    }

    public function DeleteOrder($orderId)
    {
        $order = Order::where("order_no", '=', $orderId)->first();
        $order->delete();

        return response() -> json([
            'status' => 1,
            'message' => 'Order deleted successfully'
        ], 200);    
    }

    public function markOrderAsCompleted($orderId)
    {
        $order = Order::where("order_no", '=', $orderId)->first();
        $order->statuses_id = $this->getStatusId('finished');
        $order->save();
        // insert record in complete orders table
        // $completeOrder = new CompleteOrder;
        // $completeOrder->insertRecord($order);

        // Add record to messages table
        $this->addRecordToMessagesTable($order->order_no, $order->delivery_customer, 'finished', $order->buyer_phone);

        // remove order from orders table
        // $order->delete();

        return response() -> json([
            'status' => 1,
            'message' => "Order inserted successfully",
        ], 200);
    }

    public function updateOrderStatus($orderNo, Request $request)
    {
        $order = Order::where('order_no', '=',$orderNo)->first();
        $order->statuses_id = $this->getStatusId($request->statusName);
        $order->save();        

        // Add record to messages table
        $this->addRecordToMessagesTable($order->order_no, $order->delivery_customer, $request->statusName, $order->buyer_phone);

        // If Status is finished then move record to completed_orders table
        // And then remove record from orders table
        // if($request->statusName == 'finished') {
        //     $completeOrder = new CompleteOrder;
        //     $completeOrder->insertRecord($order);   
            
        //     $order->delete();
        
        // } else {
        //     $statusId = Status::where('name', '=', $request->statusName)->pluck('id')->first();
        //     $order->statuses_id = $statusId;
        //     $order->save();
        // }

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

    public function getCompletedOrders()
    {
        $finishedStatusId = $this->getStatusId('finished');

        $completedOrders = CompleteOrder::all();
        $otherCompletedOrders = Order::where('statuses_id', '=', $finishedStatusId)->get();
        $orders = $otherCompletedOrders->merge($completedOrders);

        return response() -> json([
            'status' => 1,
            'message' => "List of all completed orders",
            'count' => sizeof($orders),
            'data' => [
                'orders' => OrderResource::collection($orders),
            ]
        ], 200);
    }

    private function getStatusId($stausName)
    {
        $getId = Status::where('name', '=', $stausName)->pluck('id')->first();
        return $getId;
    }

    
}
