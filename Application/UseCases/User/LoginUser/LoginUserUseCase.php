<?php

namespace Application\UseCases\User\LoginUser;

use Application\Contract\IAuthService;
use Application\UseCases\User\LoginUser\DTO\LoginUserInputDto;
use Application\UseCases\User\LoginUser\DTO\LoginUserOutputDto;
use Domain\Share\Exceptions\UseCaseException;
use Domain\User\Repositories\IUserRepository;

class LoginUserUseCase
{
	public function __construct(
		private readonly IUserRepository $userRepository,
		private readonly IAuthService $authService
	){}

	public function execute(LoginUserInputDto $input): LoginUserOutputDto
	{
			$user = $this->userRepository->findByEmail($input->email);
			if(empty($user->isPasswordValid($input->password))) {
				throw new UseCaseException('Invalid credentials');
			}

			$accessToken = $this->authService->generateToken($user);

			return new LoginUserOutputDto(
				token_type: $accessToken['token_type'],
				expires_in: $accessToken['expires_in'],
				access_token: $accessToken['access_token']
			);
	}
}