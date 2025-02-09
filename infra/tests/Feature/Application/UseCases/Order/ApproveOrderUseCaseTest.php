<?php

use App\Models\Order;
use App\Repositories\Eloquent\OrderRepository;
use Application\UseCases\Order\ApproveOrder\ApproveOrderUseCase;
use Application\UseCases\Order\ApproveOrder\DTO\ApproveOrderInputDto;
use Application\UseCases\Order\ApproveOrder\DTO\ApproveOrderOutputDto;
use Database\Factories\OrderFactory;

test( 'it approve an order', function () {
    $orderCreated = OrderFactory::new()->create();
    $useCase = new ApproveOrderUseCase(new OrderRepository(new Order()));
    $response = $useCase->execute(
        new ApproveOrderInputDto(
            order_id: $orderCreated->id
        )
    );
    expect($response)->toBeInstanceOf(ApproveOrderOutputDto::class);
    $this->assertDatabaseHas('orders', [
        'status_order' => 'APPROVED',
    ]);
});
