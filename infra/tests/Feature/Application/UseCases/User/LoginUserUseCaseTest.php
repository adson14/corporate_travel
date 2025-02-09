<?php

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use App\Services\AuthService;
use Application\UseCases\User\LoginUser\DTO\LoginUserInputDto;
use Application\UseCases\User\LoginUser\DTO\LoginUserOutputDto;
use Application\UseCases\User\LoginUser\LoginUserUseCase;
use Database\Factories\UserFactory;

test( 'it login a  user with valid credentials', function () {

    $userCreated = UserFactory::new()->withPassword('senha_personalizada')->create(['password' => '12345678']);
    $useCase = new LoginUserUseCase(new UserRepository(new User()), new AuthService());

    $response = $useCase->execute(
        new LoginUserInputDto(
            email: $userCreated->email,
            password: '12345678',
        )
    );

    expect($response->access_token)->not()->toBeEmpty();
    expect($response->token_type)->not()->toBeEmpty();
    expect($response->expires_in)->not()->toBeEmpty();
    expect($response)->toBeInstanceOf(LoginUserOutputDto::class);
});
