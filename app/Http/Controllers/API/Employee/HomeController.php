<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\{Order, Status, Inventory};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{OrdersChartResource, InventoryChartResource};

class HomeController extends Controller
{
    public function ordersOverview()
    {
        $statuses = Status::where('name', '<>', 'finished')->orderBy('name')->get();
        $labels = [];

        return response() -> json([
            'status' => 1,
            'message' => "Chart orders Data",
            'data' => [
                'records' => OrdersChartResource::collection($statuses),
            ]
        ], 200);        

    }

    public function inventoryOverview()
    {
        $inventory = Inventory::all();

        return response() -> json([
            'status' => 1,
            'message' => "Chart Inventory Data",
            'data' => [
                'records' => InventoryChartResource::collection($inventory),
            ]
        ], 200);            
    }
}
