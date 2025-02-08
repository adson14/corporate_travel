<?php

namespace Domain\User\Entities;
use Domain\Share\MethodsMagicsTrait;
use Domain\Share\Validation;
use Domain\Share\ValueObjects\Uuid;

class UserEntity
{
	use MethodsMagicsTrait;

	public function __construct(
		protected string $email,
		protected string $password,
		protected ?string $name = null,
		protected ?Uuid $id = null
	) {
		$this->id = $this->id ?? Uuid::random();
		$this->validate();
	}

	public function alterPassword(string $newPassword): void
	{
		$this->password = password_hash($newPassword, PASSWORD_BCRYPT);
	}

	public function signup(): void
	{
		$this->password = password_hash($this->password, PASSWORD_BCRYPT);
	}

	public function validate(): void
	{
		Validation::notEmpty($this->email);
		Validation::notEmpty($this->password);
	}

}