<?php

namespace App\Http\Controllers\API\Admin;

use DB;
use Auth;
use App\Models\{Order, CompleteOrder, Status, Message, Revenue};
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
        $this->addRecordToMessagesTable($order->order_no, $order->delivery_customer, 'finished', $order->buyer_phone, $order->item_name);

        // remove order from orders table
        // $order->delete();

        // Add Entry to revenue table
        $description = 'Order no: ' . $order->order_no . ' finished';
        $type = 'Sale';
        $amount = $order->total;
        $reference_id = $order->id;
        $this->addEntryToRevenueTable($description, $type, $amount, $reference_id);             

        return response() -> json([
            'status' => 1,
            'message' => "Order inserted successfully",
        ], 200);
    }

    public function updateOrderStatus($orderNo, Request $request)
    {
        $order = Order::where('order_no', '=',$orderNo)->first();
        $order->statuses_id = $this->getStatusId($request->statusName);
        $order->user_id = Auth::id();
        $order->save();        

        // Add record to messages table
        $this->addRecordToMessagesTable($order->order_no, $order->delivery_customer, $request->statusName, $order->buyer_phone, $order->item_name);

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

        $finished_id = Status::where('name', '=', 'finished')->pluck('id')->first();
        // if order is finished then add record to revenues table else remove record from revenues table
        if($order->statuses_id == $finished_id ) {
            $description = 'Order no: ' . $order->order_no . ' finished';
            $type = 'Sale';
            $amount = $order->total;
            $reference_id = $order->id;
            $this->addEntryToRevenueTable($description, $type, $amount, $reference_id);    

        } else {
            $this->deleteEntryFromRevenueTable('Sale', $order->id);
        }


        return response() -> json([
            'status' => 1,
            'message' => "Order status has been updated successfully",
        ], 200);

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

    ////////////////////////////////////////////////////////////////////////////////////    

    private function addRecordToMessagesTable($order_no, $delivery_customer, $type, $phone_number, $product)
    {
        $record = [
            'order_no' => $order_no,
            'name' =>  $delivery_customer,
            'type' => $type,
            'phone_number' => $phone_number,
            'product' => $product,
        ];

        $message = new Message;
        $message->insertRecord($record);

        return;
    }

    private function getStatusId($stausName)
    {
        $getId = Status::where('name', '=', $stausName)->pluck('id')->first();
        return $getId;
    }

    private function addEntryToRevenueTable($description, $type, $amount, $reference_id)
    {
        $revenue = new Revenue;
        $revenue->insertRecord($description, $type, $amount, $reference_id);
    }   

    private function deleteEntryFromRevenueTable($type, $reference_id)
    {
        $revenue = Revenue::where('reference_id', '=', $reference_id)
                            ->where('type', '=', $type)
                            ->first();
                            
        if($revenue) {
            $revenue->delete();     
        }
    }    
    
    
}
