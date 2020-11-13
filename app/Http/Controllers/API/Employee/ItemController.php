<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\{Item};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;


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
}
