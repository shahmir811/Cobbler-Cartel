<?php

namespace App\Http\Controllers\API\Admin;

use DB;
use Carbon\Carbon;
use App\Models\{Order, Revenue, Status};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{RevenueResource};

class RevenueController extends Controller
{
    public function getRevenues(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $dispatch_id = Status::where('name', '=', 'dispatched')->pluck('id')->first();
        $dispatchAmount = Order::where('statuses_id', '=', $dispatch_id)
                                ->select(DB::raw('SUM(total) as pending'))
                                ->first();
        
        $date = Carbon::createFromDate($year, $month);
        // $revenues = Revenue::orderBy('created_at', 'desc')->get();
        $revenues = Revenue::whereMonth('created_at', $date->month)
                            ->whereYear('created_at', $date->year)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return response() -> json([
            'status' => 1,
            'message' => 'Get revenue list',
            'data' => [
                'revenues' => RevenueResource::collection($revenues),
                'dispatchAmount' => $dispatchAmount['pending'], 
            ]            
        ],200);               
    }

}
