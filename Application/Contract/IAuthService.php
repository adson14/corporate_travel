<?php

namespace Application\Contract;

use Domain\User\Entities\UserEntity;

interface IAuthService
{
	public function generateToken(UserEntity $user): array;
}