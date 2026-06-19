<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]) ;
       
        if(!Auth::attempt($credentials)){
            return response()->json(['message'=>'Identifiant non valide'], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken ; 
        return response()->json([
            'token'=> $token , 
            'user'=> $user,
        ]);
       
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete() ; 
        return response()->json(['message'=>'Déconnecté']);
    }
}
