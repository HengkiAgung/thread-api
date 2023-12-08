<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken("API TOKEN")->plainTextToken;

            return response()->json(["status" => "success", "data" => $token], 200);
        }

        return response()->json(["status" => "fail", "message" => "cek email dan password"], 200);
    }

    function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ]);
        }

        $password = Hash::make($request->password);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $password,
        ]);

        if ($request->avatar) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id;
            $file->storeAs('avatar', $filename, 'public');

            $user->update([
                "avatar" => $filename,
            ]);
        }

        $token = $user->createToken("API TOKEN")->plainTextToken;

        return response()->json(["status" => "success", "data" => $token], 200);
    }

    function me() : Returntype {
        return response()->json(['status' => 'success'], 200);
    }
}
