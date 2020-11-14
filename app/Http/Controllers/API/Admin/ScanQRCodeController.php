<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\{Order, Status, Message};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{ScanOrderResource, StatusResource};

class ScanQRCodeController extends Controller
{
    public function getAllStatuses()
    {
        $statuses = Status::all();

        return response() -> json([
            'status' => 1,
            'message' => "Order record",
            'data' => [
                'statuses' => StatusResource::collection($statuses)
            ]
        ], 200);

    }

    public function getOrder($orderNo)
    {
        $order = Order::where('order_no', '=', $orderNo)->first();
        
        return response() -> json([
            'status' => 1,
            'message' => "Order record",
            'data' => [
                'order' => new ScanOrderResource($order)
            ]
        ], 200);
    }

    public function updateOrderList(Request $request)
    {
        $records = $request->records;

        foreach ($records as $key => $record) {
            $order = Order::where('order_no', '=', $record['order_no'])->first();

            // only update record if status changed
            if($order->statuses_id != $record['statuses_id']) {
                $order->statuses_id = $record['statuses_id'];
                $order->save();
                
                // store record in statuses table
                $this->addRecordToMessagesTable($order->order_no, $order->delivery_customer, $order->status->name, $order->buyer_phone);
            }
        }

        return response() -> json([
            'status' => 1,
            'message' => "Orders statuses have been updated",
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
