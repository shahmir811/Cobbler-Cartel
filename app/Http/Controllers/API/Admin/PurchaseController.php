<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\{Purchase};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PurchaseResource;
use App\Http\Requests\AddPurchaseRequest;


class PurchaseController extends Controller
{
    public function getAllPurchases()
    {
        $purchases = Purchase::all();
        return response() -> json([
            'status' => 1,
            'message' => 'Get list of inventory items', 
            'data' => [
                'purchases' => PurchaseResource::collection($purchases)
            ]            
        ],200);        
    }

    public function addNewPurchase(AddPurchaseRequest $request)
    {
        $purchase = new Purchase;
        $purchase->item_id = $request->item_id;
        $purchase->quantity = $request->quantity;
        $purchase->total_amount = $purchase->getTotalAmount($request->item_id, $request->quantity);
        $purchase->save();

        return response() -> json([
            'status' => 1,
            'message' => 'New purchase added', 
            'data' => [
                'purchase' => new PurchaseResource($purchase)
            ]            
        ],200);        

    }

    public function updatePurchaseItem($id, AddPurchaseRequest $request)
    {

        $purchase = Purchase::findOrFail($id);
        $purchase->item_id = $request->item_id;
        $purchase->quantity = $request->quantity;
        $purchase->total_amount = $purchase->getTotalAmount($request->item_id, $request->quantity);
        $purchase->save();

        return response() -> json([
            'status' => 1,
            'message' => 'Purchase upadted', 
            'data' => [
                'purchase' => new PurchaseResource($purchase)
            ]            
        ],200);        

    }

    public function deletePurchaseItem($id)
    {
        Purchase::where('id', '=', $id)->delete();
        
        return response()->json([
            'status' => 1,
            'message' => 'Purchase item deleted successfully', 
        ], 200);               
    }
        
}
