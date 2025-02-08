<?php

namespace Application\UseCases\User\RegisterUser\DTO;

class RegisterUserInputDto
{

	public function __construct(
		public string $email,
		public string $password,
		public ?string $name,
	)
	{}

}