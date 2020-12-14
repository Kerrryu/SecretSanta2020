<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SantaUserController extends Controller
{
    public function LoginSanta(Request $request) {
        if(Auth::user() == null) {
            $username = $request->input("username");
            $password = $request->input("password");

            if(Auth::attempt(['name' => $username, 'password' => $password])) {
                $user = User::where("name", $username)->first();
                Auth::loginUsingId($user->id, true);
                return "LOGIN";
            } else {
                return "NO";
            }
        } else {
            return "Already Logged In";
        }
    }
}
