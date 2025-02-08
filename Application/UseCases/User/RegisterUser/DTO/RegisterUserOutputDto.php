<?php

namespace Application\UseCases\User\RegisterUser\DTO;

class RegisterUserOutputDto
{
	public function __construct(
		public string $email,
		public ?string $name,
		public string $access_token
	)
	{}
}