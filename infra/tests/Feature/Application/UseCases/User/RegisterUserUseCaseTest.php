<?php


use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Application\UseCases\User\RegisterUser\DTO\RegisterUserInputDto;
use Application\UseCases\User\RegisterUser\DTO\RegisterUserOutputDto;
use Application\UseCases\User\RegisterUser\RegisterUserUseCase;

test( 'it registers a new user and persists the data in the database', function () {

    $useCase = new RegisterUserUseCase(new UserRepository(new User()));

    $response = $useCase->execute(
        new RegisterUserInputDto(
            email: '5oQpK@example.com',
            password: '12345678',
            name: 'John Doe',
        )
    );

    expect($response)->toBeInstanceOf(RegisterUserOutputDto::class);
    expect($response->access_token)->not()->toBeEmpty();
    $this->assertDatabaseHas('users', [
        'email' => '5oQpK@example.com',
        'name' => 'John Doe',
    ]);
});
