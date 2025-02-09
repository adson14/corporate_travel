<?php

namespace Application\UseCases\User\RegisterUser;

use Application\UseCases\User\RegisterUser\DTO\RegisterUserInputDto;
use Application\UseCases\User\RegisterUser\DTO\RegisterUserOutputDto;
use Domain\Share\Exceptions\UseCaseException;
use Domain\User\Entities\UserEntity;
use Domain\User\Repositories\IUserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterUserUseCase
{
	public function __construct(
		private readonly IUserRepository $userRepository
	)
	{}

	public function execute(RegisterUserInputDto $input): RegisterUserOutputDto
	{
		try {
			$this->userRepository->findByEmail($input->email);
			throw new UseCaseException('User already exists');
		} catch (\Exception $e) {

			$userEntity = new UserEntity();
			$user = $userEntity->signup($input->email, $input->password, $input->name);
			$userInsert = $this->userRepository->insert($user);
			$accessToken = JWTAuth::fromUser($userInsert);

			return new RegisterUserOutputDto(
				email: $user->email,
				name: $user->name,
				access_token: $accessToken
			);
		}

	}
}