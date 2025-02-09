<?php
use App\Models\Order;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderInputDto;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderOutputDto;
use Application\UseCases\Order\InsertOrder\InsertOrderUseCase;
use Database\Factories\UserFactory;
use Domain\Order\Entities\OrderEntity;
use Domain\Order\Repositories\IOrderRepository;
use Domain\Share\ValueObjects\Uuid;

test( 'it create a new order', function () {
    $userCreated = UserFactory::new()->withPassword('senha_personalizada')->create(['password' => 12345678]);
    $mockOrder = new Order([
        'id' => Uuid::random(),
        'destiny' => 'New York',
        'departure_date' => '2022-01-01',
        'return_date' => '2022-01-02',
        'status_order' => 'APPROVED',
        'user_id' => $userCreated->id,
    ]);

    $orderRepository = Mockery::mock(IOrderRepository::class);
    $orderRepository->shouldReceive('insert')
        ->once()
        ->with(Mockery::type(OrderEntity::class))
        ->andReturn($mockOrder);

    $useCase = new InsertOrderUseCase($orderRepository);
    $response = $useCase->execute(
        new InsertOrderInputDto(
            user_id: $userCreated->id,
            destiny: 'New York',
            departure_date: '2022-01-01',
            return_date: '2022-01-02',
        )
    );
    expect($response)->toBeInstanceOf(InsertOrderOutputDto::class);
})
->afterEach(function () {
    Mockery::close();
});
