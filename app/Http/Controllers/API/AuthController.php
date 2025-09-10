<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        $r->validate(['email'=>'required|email','password'=>'required']);
        $user = User::where('email',$r->email)->first();
        if (!$user || !Hash::check($r->password,$user->password)) {
            return response()->json(['message'=>'Identifiants invalides'],401);
        }
        $token = $user->createToken('access_token')->plainTextToken;
        return response()->json(['access_token'=>$token,'user'=>$user]);
    }

    public function register(Request $r)
    {
        $r->validate(['name'=>'required','email'=>'required|email|unique:users,email','password'=>'required|min:6']);
        $user = User::create([
            'name'=>$r->name,
            'email'=>$r->email,
            'password'=>Hash::make($r->password),
            'role'=>'client',
        ]);
        $token = $user->createToken('access_token')->plainTextToken;
        return response()->json(['access_token'=>$token,'user'=>$user],201);
    }
}
