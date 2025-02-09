<?php
use Application\UseCases\Order\ShowOrder\DTO\ShowOrderInputDto;
use Application\UseCases\Order\ShowOrder\DTO\ShowOrderOutputDto;
use Application\UseCases\Order\ShowOrder\ShowOrderUseCase;
use Database\Factories\UserFactory;
use Domain\Order\Entities\OrderEntity;
use Domain\Order\Enum\OrderStatusEnum;
use Domain\Order\Repositories\IOrderRepository;
use Domain\Share\ValueObjects\Uuid;
use Domain\User\Entities\UserEntity;

test( 'it show an order by id', function () {

    $createdUser = UserFactory::new()->withPassword('123456')->create();
    $order = new OrderEntity(
        user: new UserEntity(
            email: $createdUser->email,
            password: $createdUser->password,
            name: $createdUser->name,
            id: new Uuid($createdUser->id)
        ),
        destiny: 'Destino Exemplo',
        departureDate: new \DateTime('2025-05-15'),
        returnDate: new \DateTime('2025-06-15'),
        status: OrderStatusEnum::PENDING,
        created_at: new \DateTime('2025-05-15')
    );

    $orderRepository = Mockery::mock(IOrderRepository::class);

    $orderRepository->shouldReceive('find')
        ->once()
        ->with($order->id())
        ->andReturn($order);

    $useCase = new ShowOrderUseCase($orderRepository);

    $response = $useCase->execute(
        new ShowOrderInputDto(
            order_id: $order->id()
        )
    );

    expect($response)->toBeInstanceOf(ShowOrderOutputDto::class);
    expect($response->id)->toBe($order->id());
})
->afterEach(function () {
    Mockery::close();
});
