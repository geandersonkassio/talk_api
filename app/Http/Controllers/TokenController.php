<?php

namespace App\Http\Controllers;


use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\User;

class TokenController extends Controller
{

    public function generateToken(Request $request)
    {   
   
        if (!$request->has('email') || !$request->has('password')) {
            return response()->json('Informe usuário e senha', Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)->first();

        if (is_null($user) || !Hash::check($request->password, $user->password)) {
            return response()->json('Usuário ou senha inválidos', Response::HTTP_UNAUTHORIZED);
        }

        $now = time();

        $token = JWT::encode(
            [
                'id'  => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'admin' => $user->admin,
                'property' => $user->property,
                'iat' => $now,
                'exp' => $now + (60 * 60 * 24 * 3),
            ],
            env('JWT_KEY')
        );

        return response()->json([
            'id'  => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'admin' => $user->admin,
            'property' => $user->property,
            'iat' => $now,
            'exp' => $now + (60 * 60 * 24 * 3),
            'token' => $token
        ]);
    }

    public function validateToken(Request $request)
    {
        if (is_null($request->token)) {
            return response()->json('token inválido', Response::HTTP_BAD_REQUEST);
        }

        try {
            $token = JWT::decode($request->token, env('JWT_KEY'), ['HS256']);

            return response()->json(true);
        } catch (\Exception $e) {
            return response()->json(false);
        }
    }
}
