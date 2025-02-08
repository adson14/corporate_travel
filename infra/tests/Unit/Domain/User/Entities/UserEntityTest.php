<?php


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
