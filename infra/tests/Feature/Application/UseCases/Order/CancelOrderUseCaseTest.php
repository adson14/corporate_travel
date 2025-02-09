<?php

use App\Models\Order;
use App\Repositories\Eloquent\OrderRepository;
use Application\UseCases\Order\CancelOrder\CancelOrderUseCase;
use Application\UseCases\Order\CancelOrder\DTO\CancelOrderInputDto;
use Application\UseCases\Order\CancelOrder\DTO\CancelOrderOutputDto;
use Database\Factories\OrderFactory;

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
