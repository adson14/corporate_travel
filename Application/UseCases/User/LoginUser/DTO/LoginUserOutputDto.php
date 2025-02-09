<?php

namespace Application\UseCases\User\LoginUser\DTO;

class LoginUserOutputDto
{
	public function __construct(
		public string $token_type,
		public int $expires_in,
		public string $access_token
	)
	{}
}