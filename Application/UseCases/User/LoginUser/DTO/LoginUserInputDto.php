<?php

namespace Application\UseCases\User\LoginUser\DTO;

class LoginUserInputDto
{

	public function __construct(
		public string $email,
		public string $password,
	)
	{}

}