<?php

namespace Domain\User\Repositories;

use App\Models\User;
use Domain\User\Entities\UserEntity;

interface IUserRepository
{
	public function insert(UserEntity $user): User;
	public function find(string $id): UserEntity;
	public function findByEmail(string $email): UserEntity;
}