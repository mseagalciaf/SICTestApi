<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:sanctum'])->only(['isLogined']);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => false,
                'data' => 'invalid_credentials'
            ],401);
        }
        $user = User::where('email',$request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->roles=$user->getRoleNames();
        //$user->permissions=$user->getAllPermissions();

            return response()->json([
                'status' => true,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
    }

    public function logout(Request $request)
    {   
        $user=User::find($request->id);
        $user_tokens=json_decode($user->tokens()->get());
        
        if (!empty($user_tokens)) {
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'data' => 'success_logout'
            ]);            
        }

        return response()->json([
            'status' => false,
            'data' => 'wrong_logout'
        ]);  

    }

    public function isLogined(Request $request){
        return true;
    }
}
