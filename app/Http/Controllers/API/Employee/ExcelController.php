<?php

namespace App\Http\Controllers\API\Employee;

// use Excel;
use App\Models\{Message, InitialOrder};
use App\Utils\ExcelFileImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelFileImportRequest;

class ExcelController extends Controller
{
    public function importDataToDatabase(ExcelFileImportRequest $request)
    {
        $import = new ExcelFileImport;
        $import->ImportFile($request);
        $this->addRecordsToMessagesTable();
        return;
    }

    private function addRecordsToMessagesTable()
    {
        $orders = InitialOrder::all();
        $message = new Message;

        foreach ($orders as $order) {
            $record = [
                'order_no' => $order->order_no,
                'name' =>  $order->name,
                'type' => $order->status,
                'phone_number' => $order->phone_number,
                'product' => $order->product,
            ];            

            $message->insertRecord($record);
            $order->delete();
        }
    }
}
