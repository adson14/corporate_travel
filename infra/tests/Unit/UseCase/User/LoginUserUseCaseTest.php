<?php

use Application\Contract\IAuthService;
use Application\UseCases\User\LoginUser\DTO\LoginUserInputDto;
use Application\UseCases\User\LoginUser\DTO\LoginUserOutputDto;
use Application\UseCases\User\LoginUser\LoginUserUseCase;
use Database\Factories\UserFactory;
use Domain\User\Entities\UserEntity;
use Domain\User\Repositories\IUserRepository;

test( 'it login a  user with valid credentials', function () {

    $userCreated = UserFactory::new()->withPassword('senha_personalizada')->create(['password' => '12345678']);
    $userEntity = new UserEntity();

    $user = $userEntity->signin(
        id: $userCreated->id,
        email: $userCreated->email,
        password: $userCreated->password,
        name: $userCreated->name
    );

    $userRepository = Mockery::mock(IUserRepository::class);
    $userRepository->shouldReceive('findByEmail')
        ->once()
        ->with('5oQpK@example.com')
        ->andReturn($user);

    $authService = Mockery::mock(IAuthService::class);
    $authService->shouldReceive('generateToken')
        ->once()
        ->with(Mockery::type(UserEntity::class))
        ->andReturn(
            [
                'access_token' => 'mocked-token',
                'token_type' => 'bearer',
                'expires_in' => 3600,
            ]
        );


    $useCase = new LoginUserUseCase($userRepository, $authService);
    $response = $useCase->execute(
        new LoginUserInputDto(
            email: '5oQpK@example.com',
            password: '12345678',
        )
    );

    expect($response->access_token)->not()->toBeEmpty();
    expect($response->token_type)->not()->toBeEmpty();
    expect($response->expires_in)->not()->toBeEmpty();
    expect($response)->toBeInstanceOf(LoginUserOutputDto::class);
})
->afterEach(function () {
    Mockery::close();
});
