<?php
use App\Models\Order;
use App\Models\User;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\UserRepository;
use Application\UseCases\Order\CancelOrder\CancelOrderUseCase;
use Application\UseCases\Order\CancelOrder\DTO\CancelOrderInputDto;
use Application\UseCases\Order\CancelOrder\DTO\CancelOrderOutputDto;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderInputDto;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderOutputDto;
use Application\UseCases\Order\InsertOrder\InsertOrderUseCase;
use Database\Factories\OrderFactory;
use Database\Factories\UserFactory;

test( 'it cancel an order', function () {
    $orderCreated = OrderFactory::new()->create();
    $useCase = new CancelOrderUseCase(new OrderRepository(new Order()));
    $response = $useCase->execute(
        new CancelOrderInputDto(
            order_id: $orderCreated->id
        )
    );
    expect($response)->toBeInstanceOf(CancelOrderOutputDto::class);
    $this->assertDatabaseHas('orders', [
        'status_order' => 'CANCELED',
    ]);
});
