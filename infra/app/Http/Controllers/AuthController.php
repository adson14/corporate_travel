<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Application\UseCases\User\RegisterUser\DTO\RegisterUserInputDto;
use Application\UseCases\User\RegisterUser\RegisterUserUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Email ou senha inválido'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request, RegisterUserUseCase $useCase)
    {
       $response = $useCase->execute(
           new RegisterUserInputDto(
               email: $request->email,
               password: $request->password,
               name: $request->name
           )
       );
       return response()->json($response)->setStatusCode(Response::HTTP_CREATED);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
