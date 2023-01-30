<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class Authentication extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:15|min:8'
        ], [
                'unique' => 'unsuccessful registration due to email is already taken'
            ]);

        $errors = [];
        foreach ($validator->errors()->messages() as $error) {
            foreach ($error as $err_item) {
                array_push($errors, $err_item);
            }
        }

        if ($validator->fails()) {
            return response([
                'errors' => $errors,
            ], 400);
        }

        $validated = $validator->safe();
        $email = $validated->email;
        $password = $validated->password;

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        return response(['message' => 'user successfully registered'], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|max:15|min:8'
        ]);

        $errors = [];
        foreach ($validator->errors()->messages() as $error) {
            foreach ($error as $err_item) {
                array_push($errors, $err_item);
            }
        }

        if ($validator->fails()) {
            return response([
                'erros' => $errors,
            ], 400);
        }

        $validated = $validator->safe();
        $email = $validated->email;
        $password = $validated->password;

        $user = User::where('email', $email)->first(['id', 'email', 'password']);

        if (!$user || !Hash::check($password, $user->password)) {
            return response(['message' => 'invalid credential!']);
        }

        $token = $user->createToken("$user->id.$user->username", ['server:update']);
        return response(['access_token' => $token->plainTextToken], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(null, 204);
    }
}