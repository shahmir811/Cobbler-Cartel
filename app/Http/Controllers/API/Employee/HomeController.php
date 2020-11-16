<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\{Order, Status, Inventory};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function ordersOverview()
    {
        $statuses = Status::where('name', '<>', 'finished')->pluck('name')->toArray();

        return response() -> json([
            'status' => 1,
            'message' => "Charts Data",
            'data' => [
                'statuses' => $statuses
            ]
        ], 200);        

    }
}
