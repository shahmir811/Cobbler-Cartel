<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\{Log};
use App\Utils\ExcelFileImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelFileImportRequest;

class ExcelController extends Controller
{
    public function importDataToDatabase(ExcelFileImportRequest $request)
    {
        $import = new ExcelFileImport;
        $this->addEntryToLogTable();
        
        return $import->ImportFile($request);
    }

    private function addEntryToLogTable()
    {
        $description = 'Import excel file';
        $type = '';
        $amount = 0;
        $log = new Log;
        $log->insertLog($description, $type, $amount);

    }
}
