<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcelFileImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "import_file" => "required|max:10000|mimes:csv,txt"
        ];
    }

    public function messages()
    {
        return [
            'import_file.max' => 'File size must be less than 10MB',
            'import_file.mimes' => 'Only upload file with .csv extension',
        ];
    }
}
