<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\{Inventory, Log};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\InventoryResource;
use App\Http\Requests\AddInventoryRequest;

class InventoryController extends Controller
{
    public function getAllInventory() 
    {
        $records = Inventory::all();
        return response() -> json([
            'status' => 1,
            'message' => 'Get list of inventory items', 
            'data' => [
                'inventory' => InventoryResource::collection($records)
            ]            
        ],200);
    }

    public function addNewInventoryItem(AddInventoryRequest $request)
    {
        if(!$this->checkIfSimilarItemIdRecordAlreadyExists($request->item_id)) {
            $newItem = new Inventory;
            $newItem->quantity = $request->quantity;
            $newItem->item_id = $request->item_id;
            $newItem->save();

            // Add Log
            $description = 'Add item in inventory: ' . $newItem->item->name;
            $type = '';
            $amount = 0;
            $this->addEntryToLogsTable($description, $type, $amount);            

            return response()->json([
                'status' => 1,
                'message' => 'Added new inventory item', 
                'data' => [
                    'inventory' => new InventoryResource($newItem)
                ]
            ], 200);      
                        
        } else {
            $inventoryItem = Inventory::where('item_id', '=', $request->item_id)->first();
            $inventoryItem->quantity = $request->quantity;
            $inventoryItem->save();
            
            
            // Add Log
            $description = 'Update quantity of ' . $inventoryItem->item->name . ' in inventory';
            $type = '';
            $amount = 0;
            $this->addEntryToLogsTable($description, $type, $amount);       

            return response()->json([
                'status' => 1,
                'message' => 'Record already exists, so updated its quantity', 
                'data' => [
                    'inventory' => new InventoryResource($inventoryItem)
                ]
            ], 200);                  
        }

    }

    public function updateInventoryItem($id, AddInventoryRequest $request)
    {
        $inventoryItem = Inventory::findOrFail($id);
        $inventoryItem->quantity = $request->quantity;
        $inventoryItem->item_id = $request->item_id;
        $inventoryItem->save();

        // Add Log
        $description = 'Changed inventory item quantity: ' . $inventoryItem->item->name;
        $type = '';
        $amount = 0;
        $this->addEntryToLogsTable($description, $type, $amount);    

        return response()->json([
            'status' => 1,
            'message' => 'Updated inventory item', 
            'data' => [
                'inventory' => new InventoryResource($inventoryItem)
            ]
        ], 200);    

    }

    public function deleteInventoryItem($id)
    {
        $inventory = Inventory::where('id', '=', $id)->first();
        // Add Log
        $description = 'Removed inventory item: ' . $inventory->item->name;
        $type = '';
        $amount = 0;
        $this->addEntryToLogsTable($description, $type, $amount);    

        $inventory->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Inventory item deleted successfully', 
        ], 200);               
    }

    private function checkIfSimilarItemIdRecordAlreadyExists($item_id){
        return Inventory::where('item_id', '=', $item_id)->exists();
    }

    private function addEntryToLogsTable($description, $type, $amount)
    {
        $log = new Log;
        $log->insertLog($description, $type, $amount);
    }
}
