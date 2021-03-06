<?php

namespace App\Http\Controllers\API\Employee;

use Auth;
use App\Models\{Order, Status, Message, Item, Inventory, Log};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{StatusResource, ItemResource, OrderResource};

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
                'order' => new OrderResource($order)
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
                $order->user_id = Auth::id();
                $order->save();

                // Add Log
                $description = 'Changed status of order: ' . $order->order_no . ' to ' . $order->status->name;
                $type = '';
                $amount = 0;
                $this->addEntryToLogsTable($description, $type, $amount);    
                
                // store record in statuses table
                $this->addRecordToMessagesTable($order->order_no, $order->delivery_customer, $order->status->name, $order->buyer_phone, $order->item_name);
            }
        }

        return response() -> json([
            'status' => 1,
            'message' => "Orders statuses have been updated",
        ], 200);        

    }


    public function getItem($itemCode)
    {
        $item = Item::where('item_code', '=', $itemCode)->first();

        return response() -> json([
            'status' => 1,
            'message' => "Item record",
            'data' => [
                'item' => new ItemResource($item)
            ]
        ], 200);

    }


    public function updateItemsList(Request $request)
    {
        $records = $request->records;

        foreach ($records as $key => $record) {
            // convert quantity from string to number
            $quantity = (int)$record['quantity'];     

            if($quantity != 0) {
            
                $item = Item::where('item_code', '=', $record['item_code'])->first();
                $inventory = Inventory::where('item_id', '=', $item->id)->first();
                if($inventory) {
                    $inventory->quantity += $quantity;
                    $inventory->save();

                    // Add Log
                    $description = 'Inventory Item: ' . $inventory->item->name . ' is changed by ' . $quantity;
                    $type = '';
                    $amount = 0;
                    $this->addEntryToLogsTable($description, $type, $amount);    
                }
                else {
                    $inventory = new Inventory;
                    $inventory->item_id = $item->id;
                    $inventory->quantity = $quantity;
                    $inventory->save();

                    // Add Log
                    $description = 'New inventory item : ' . $inventory->item->name . ' is added';                 
                }
            }

        }

        return response() -> json([
            'status' => 1,
            'message' => "Inventory items quantity has been updated",
        ], 200);        

    }




    ////////////////////////////////////////////////////////////////////////////////

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

    private function addEntryToLogsTable($description, $type, $amount)
    {
        $log = new Log;
        $log->insertLog($description, $type, $amount);
    }    

}
