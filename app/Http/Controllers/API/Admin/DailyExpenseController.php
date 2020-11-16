<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\{DailyExpense};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DailyExpenseResource;
use App\Http\Requests\Admin\AddDailyExpenseRequest;

class DailyExpenseController extends Controller
{
    public function getAllExpenses()
    {
        $expenses = DailyExpense::orderBy('created_at', 'desc')->get();

        return response() -> json([
            'status' => 1,
            'message' => "Daily expenses list",
            'data' => [
                'expenses' => DailyExpenseResource::collection($expenses),
            ]
        ], 200);
    }

    public function addExpense(AddDailyExpenseRequest $request) 
    {
        $expense = new DailyExpense;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->save();

        return response() -> json([
            'status' => 1,
            'message' => "Expense added",
            'data' => [
                'expense' => new DailyExpenseResource($expense),
            ]
        ], 200);        

    }

    public function deleteExpense($id)
    {  
        $expense = DailyExpense::findOrFail($id);
        $expense->delete();

        return response() -> json([
            'status' => 1,
            'message' => "Expense deleted",
        ], 200);            
        
    }
}
