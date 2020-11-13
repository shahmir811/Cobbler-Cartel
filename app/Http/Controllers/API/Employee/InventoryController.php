<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\{Inventory};
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
        Inventory::where('id', '=', $id)->delete();
        
        return response()->json([
            'status' => 1,
            'message' => 'Inventory item deleted successfully', 
        ], 200);               
    }

    private function checkIfSimilarItemIdRecordAlreadyExists($item_id){
        return Inventory::where('item_id', '=', $item_id)->exists();
    }
}
