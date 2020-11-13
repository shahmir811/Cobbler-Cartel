<?php

namespace App\Http\Controllers\API\Employee;

use Hash;
use App\Models\{User};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Employee\{UpdatePasswordRequest};

class UserController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request, $id)
    {
        User::find($request->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return response() -> json([
            'status' => 1,
            'message' => 'User password updated',
        ], 200);
    }
    
}
