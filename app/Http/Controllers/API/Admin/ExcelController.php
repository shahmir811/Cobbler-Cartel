<?php

namespace App\Http\Controllers\API\Admin;

// use Excel;
// use App\Models\{Order};
// use App\Imports\OrdersImport;
use App\Utils\ExcelFileImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelFileImportRequest;

class ExcelController extends Controller
{
    public function importDataToDatabase(ExcelFileImportRequest $request)
    {
        $import = new ExcelFileImport;
        return $import->ImportFile($request);
    }
}
