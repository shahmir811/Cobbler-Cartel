<?php

namespace App\Utils;

use Excel;
use App\Models\{Order};
use App\Imports\OrdersImport;
use Illuminate\Http\Request;


class ExcelFileImport 
{

  public function ImportFile(Request $request)
  {
    Excel::import(new OrdersImport(), $request->file('import_file'));

    return response() -> json([
        'status' => 1,
        'message' => 'File imported successfully'
    ], 200);
  }

}