<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function register(Request $request)
    {        
        
        
        $validatedData = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required' ,'confirmed'],
        ]);
        if ($validatedData->fails()) {
        
            return response()->json($validatedData->errors());
            
        }

        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password" => Hash::make($request->password),
            'role_id' => Role::ROLE_USER,
        ]);
        return response()->json(["message"=>"user created "]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
 
            return response()->json([
                'access_token' =>$token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
                ]);

        }
        return response()->json(['error' => 'Invalid credentials'], 401);

    }
    public function refresh()
    {
        // Pass true as the first param to force the token to be blacklisted "forever".
        // The second parameter will reset the claims for the new token
        $refreshToken = auth()->refresh(true, true);
        return response()->json([
            'refresh_token' =>$refreshToken,
        ]);
    }
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}