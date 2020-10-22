<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Models\{User, Role};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Auth\{LoginFormRequest, RegisterFormRequest};


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /////////////////////////////////////////////////////////////////////////
    public function register(RegisterFormRequest $request) 
    {
        $newUser = new User;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->role_id = $request->role_id;
        $newUser->password = bcrypt($request->password);
        $newUser->save();

        return response() -> json([
            'status' => 1,
            'message' => 'New user registered successfully'
        ], 201);
    }

    /////////////////////////////////////////////////////////////////////////
    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    /////////////////////////////////////////////////////////////////////////
    public function me()
    {
        return response()->json([
            'data' => [
                // 'user' => $this->guard()->user()
                'user' => new UserResource($this->guard()->user())
                ]
            ]
        );
    }    
    
    /////////////////////////////////////////////////////////////////////////
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }    
    
    /////////////////////////////////////////////////////////////////////////
    public function guard()
    {
        return Auth::guard();
    }    
    
    /////////////////////////////////////////////////////////////////////////    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

}
