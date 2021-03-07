<?php

namespace App\Http\Controllers;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $login = $request->validated();

        if( Auth::attempt($login) ) {
            $user = Auth::user();
            $token = $user->createToken('authentication')->accessToken;

            return new JsonResponse([
               'access_token' => $token
            ]);
        }
        return response(null, 401);
    }

}
