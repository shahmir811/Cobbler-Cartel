<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\{Log};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LogsResource;

class LogsController extends Controller
{
    public function getLogs()
    {
        $logs = Log::orderBy('created_at', 'desc')->get();

        return response() -> json([
            'status' => 1,
            'message' => 'Get logs list', 
            'data' => [
                'logs' => LogsResource::collection($logs)
            ]            
        ],200);           
    }
}
