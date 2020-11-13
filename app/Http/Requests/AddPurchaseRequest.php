<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPurchaseRequest extends FormRequest
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
            'quantity' => 'required|integer',
            'item_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'item_id.required' => 'Select item from dropdown',
            'item_id.integer' => 'Select item from dropdown',
        ];
    }
        
}
