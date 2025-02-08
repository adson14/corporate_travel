<?php


use App\Models\User;
use Application\UseCases\User\RegisterUser\DTO\RegisterUserInputDto;
use Application\UseCases\User\RegisterUser\DTO\RegisterUserOutputDto;
use Application\UseCases\User\RegisterUser\RegisterUserUseCase;
use Domain\Share\ValueObjects\Uuid;
use Domain\User\Entities\UserEntity;
use Domain\User\Repositories\IUserRepository;

test( 'it registers a new user ', function () {
    $mockUser = new User([
        'id' => Uuid::random(),
        'name' => 'John Doe',
        'email' => '5oQpK@example.com',
    ]);
    $userRepository = Mockery::mock(IUserRepository::class);
    $userRepository->shouldReceive('insert')
        ->once()
        ->with(Mockery::type(UserEntity::class))
        ->andReturn($mockUser);

    $useCase = new RegisterUserUseCase($userRepository);
    $response = $useCase->execute(
        new RegisterUserInputDto(
            email: '5oQpK@example.com',
            password: '12345678',
            name: 'John Doe',
        )
    );
    expect($response)->toBeInstanceOf(RegisterUserOutputDto::class);
})
->afterEach(function () {
    Mockery::close();
});
