<?php


use Database\Factories\UserFactory;
use Domain\Share\ValueObjects\Uuid;
use Domain\User\Entities\UserEntity;

test('should be create an user object', function () {
    $user = new UserEntity(
      email: '2fTqA@example.com',
      password: '123456',
      name: 'adson souza'
    );

    expect($user->name)->toBe('adson souza');
    expect($user)->toBeInstanceOf(UserEntity::class);
});

test('should be create an user object from read model', function () {
    $userEntity = new UserEntity();
    $user = $userEntity::fromReadModel(
      email: '2fTqA@example.com',
      name: 'adson souza',
      id: Uuid::random()
    );
    expect($user->name)->toBe('adson souza');
    expect($user)->toBeInstanceOf(UserEntity::class);
});

test('should be create an user object from signup model', function () {
    $userEntity = new UserEntity();
    $user = $userEntity->signup(
      email: '2fTqA@example.com',
      password: '123456',
      name: 'adson'
    );
    expect($user->name)->toBe('adson');
    expect($user)->toBeInstanceOf(UserEntity::class);
});

test('should be create an user object from signin model', function () {

    $password = '123456';
    $userCreated = UserFactory::new()->withPassword('senha_personalizada')->create(['password' => $password]);
    $userEntity = new UserEntity();

    $user = $userEntity->signin(
      id: $userCreated->id,
      email: $userCreated->email,
      password: $userCreated->password,
      name: $userCreated->name
    );

    $validPassword = $user->isPasswordValid('123456');

    expect($validPassword)->toBeTrue();
    expect($user->name)->toBe($userCreated->name);
    expect($user)->toBeInstanceOf(UserEntity::class);
});

test( 'exception should be thrown when password is invalid', function () {
    $password = '123456';
    $userCreated = UserFactory::new()->withPassword('senha_personalizada')->create(['password' => $password]);

    $userEntity = new UserEntity();
    $user = $userEntity->signin(
        id: $userCreated->id,
        email: $userCreated->email,
        password: $userCreated->password,
        name: $userCreated->name
    );

    $validPassword = $user->isPasswordValid('1234567');
    expect($validPassword)->toBeFalse();
});

