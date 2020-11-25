<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Hash;
class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        \request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', \request('email'))->first();

        if ( $user && Hash::check(\request('password'), $user->password)) {
            return response()->json([
                'access_token' => $user->createToken('token_base_name')->plainTextToken,
                'expired_at' => time() + (200 * 60),
                'status' => 'success',
                'name' => $user->name
            ]);
        }

		return response()->json([
			'status' => 'error',
			'message' => 'ایمیل یا رمز عبور نادرست می باشد.'
		]);
    }

    public function register(Request $request)
    {
       
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'access_token' => $user->createToken('token_base_name')->plainTextToken,
            'expired_at' => time() + (200 * 60),
            'status' => 'success',
            'name' => $user->name
        ]);
    }

    public function user(Request $request)
    {
    	return response()->json([
    		'name' => $request->user()->name,
    		'email' => $request->user()->email
    	]);
    }

    public function logout() 
    {
        \request()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success'
        ], 200);
        
    }
}
