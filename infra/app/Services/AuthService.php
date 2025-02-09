<?php

namespace App\Services;

use App\Models\User;
use Application\Contract\IAuthService;
use Domain\User\Entities\UserEntity;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements IAuthService
{
	public function generateToken(UserEntity $user): array
	{
        $userLogged = new User([
            'id' => $user->id(),
            'name' => $user->name ,
            'email' => $user->email,
            'password' => $user->password,
        ]);
		return $this->respondWithToken(JWTAuth::fromUser($userLogged));
	}

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
