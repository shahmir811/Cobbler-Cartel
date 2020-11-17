<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\{Purchase, Revenue};
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

        // Add Entry To revenues table
        $description = 'Item: ' . $purchase->item->name . ' , quantity: ' . $purchase->quantity;
        $type = 'Purchase';
        $amount =  $purchase->total_amount;
        $reference_id = $purchase->id;
        $this->addEntryToRevenueTable($description, $type, $amount, $reference_id);

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

        // Update Entry in revenue table
        $description = 'Item: ' . $purchase->item->name . ' , quantity: ' . $purchase->quantity;
        $type = 'Purchase';
        $amount =  $purchase->total_amount;
        $reference_id = $purchase->id;
        $this->updateEntyInRevenueTable($description, $type, $amount, $reference_id);


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

        // Remove entry from revenue table
        $this->deleteEntryFromRevenueTable('Purchase', $id);
        
        return response()->json([
            'status' => 1,
            'message' => 'Purchase item deleted successfully', 
        ], 200);               
    }
        

    ////////////////////////////////////////////////////////////////////////////////////
    private function addEntryToRevenueTable($description, $type, $amount, $reference_id)
    {
        $revenue = new Revenue;
        $revenue->insertRecord($description, $type, $amount, $reference_id);
    }    

    private function updateEntyInRevenueTable($description, $type, $amount, $reference_id)
    {
        $revenue = Revenue::where('reference_id', '=', $reference_id)
                            ->where('type', '=', $type)
                            ->first();

        $revenue->description = $description;
        $revenue->amount = $amount;
        $revenue->save();
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
