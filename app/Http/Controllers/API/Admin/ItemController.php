<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\{Item, Inventory, Purchase};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Requests\AddItemRequest;


class ItemController extends Controller
{
    public function getAllItems()
    {
        $items = Item::all();
        return response()->json([
            'status' => 1,
            'message' => 'Get list of items', 
            'data' => [
                'items' => ItemResource::collection($items)
            ]
        ], 200);
    }

    public function addItem(AddItemRequest $request)
    {
        $newItem = new Item;
        $newItem->name = $request->name;
        $newItem->price = $request->price;
        $newItem->save();

        return response()->json([
            'status' => 1,
            'message' => 'Added new item', 
            'data' => [
                'item' => new ItemResource($newItem)
            ]
        ], 200);

    }

    public function updateItem($id, AddItemRequest $request)
    {
        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->price = $request->price;
        $item->save();

        return response()->json([
            'status' => 1,
            'message' => 'Item updated successfully', 
            'data' => [
                'item' => new ItemResource($item)
            ]
        ], 200);        
    }

    public function deleteItem($id)
    {
        // 1 - delete all records from inventories table
        Inventory::where('item_id', '=', $id)->delete();

        // 2 - delete all records from purchases table 
        Purchase::where('item_id', '=', $id)->delete();

        // 3 - delete entry from items table
        Item::where('id', '=', $id)->delete();


        return response()->json([
            'status' => 1,
            'message' => 'Item deleted successfully', 
        ], 200);       

    }
}
