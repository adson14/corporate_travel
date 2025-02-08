<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Domain\Share\Exceptions\NotFoundException;
use Domain\Share\Exceptions\RepositoryException;
use Domain\User\Entities\UserEntity;
use Domain\User\Repositories\IUserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository implements IUserRepository
{

    public function __construct(
        protected User $userModel
    )
    {}

    public function insert(UserEntity $user): User
    {
        try{
            return $this->userModel->create([
                'id' => $user->id(),
                'email' => $user->email,
                'name' => $user->name,
                'password' => $user->password
            ]);
        } catch (\Exception $e) {
            throw new RepositoryException('Failed to insert user.');
        }

    }

    public function find(string $id): UserEntity
    {
        if(!$userModel = $this->userModel->find($id)){
            throw new NotFoundException('User not found.');
        }

        return $this->toEntity($userModel);
    }


    public function findByEmail(string $email): UserEntity
    {
        if(!$userModel = $this->userModel->where('email', $email)->first()){
            throw new NotFoundException('User not found.');
        }

        return $this->toEntity($userModel);
    }

    private  function toEntity(User $user): UserEntity
    {
        return UserEntity::signin(
            $user->id,
            $user->email,
            $user->password,
            $user->name
        );
    }

}
