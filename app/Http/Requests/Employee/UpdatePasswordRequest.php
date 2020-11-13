<?php

namespace App\Http\Requests\Employee;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'old_password' => [
                'required',
                new MatchOldPassword($this->user())
            ],
            'new_password' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Old password is required',
            'new_password.required' => 'New password is required',
            'new_password.required' => 'New password must be atleast 6 characters long',
        ];
    }

}
