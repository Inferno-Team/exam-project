<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function logIn(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'password' => 'required|min:8'
        ]);
        $user = User::where('name', $request->name)->first();
        if (!isset($user)) {
            return response()->json([
                'errors' => ['name' => ['لم يتم العثور على المستخدم']]
            ], 422);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => ['match' => ['اسم المستخدم و كلمة السر لا توافق بياناتنا']]
            ], 422);
        }
        $token = $user->createToken($user->name . '#exam')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'msg' => 'token deleted successfully'
        ], 200);
    }
}
