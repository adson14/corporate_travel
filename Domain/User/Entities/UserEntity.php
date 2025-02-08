<?php

namespace Domain\User\Entities;
use Domain\Share\MethodsMagicsTrait;
use Domain\Share\Validation;
use Domain\Share\ValueObjects\Uuid;

class UserEntity
{
	use MethodsMagicsTrait;

	protected ?string $email;
	protected ?string $password;
	protected ?string $name;
	protected Uuid $id;

	public function __construct(
		?string $email = null,
		?string $password = null,
		?string $name = null,
		?Uuid $id = null
	) {
		$this->email = $email;
		$this->password = $password;
		$this->name = $name;
		$this->id = $id ?? Uuid::random();
	}

	public static function signin(string $id,string $email, string $password, ?string $name = null): self
	{
		$user = new self($email, $password, $name, new Uuid($id));
		Validation::notEmpty($user->email);
		Validation::notEmpty($user->password);
		return $user;
	}

	public static function fromReadModel(string $email, ?string $name, string $id): self
	{
		return new self($email, null, $name, new Uuid($id));
	}

	public function alterPassword(string $newPassword): void
	{
		$this->password = password_hash($newPassword, PASSWORD_BCRYPT);
	}

	public function signup(string $email, string $password, ?string $name = null): self
	{
		$user = new self($email, $password, $name, Uuid::random());
		Validation::notEmpty($user->email);
		Validation::notEmpty($user->password);
		$this->password = password_hash($password, PASSWORD_BCRYPT);
		return $user;
	}

	public function isPasswordValid(string $password): bool
	{
		return password_verify($password, $this->password);
	}

}