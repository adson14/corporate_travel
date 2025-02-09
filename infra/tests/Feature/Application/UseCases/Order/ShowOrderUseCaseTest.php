<?php
use App\Models\Order;
use App\Repositories\Eloquent\OrderRepository;
use Application\UseCases\Order\ShowOrder\DTO\ShowOrderInputDto;
use Application\UseCases\Order\ShowOrder\DTO\ShowOrderOutputDto;
use Application\UseCases\Order\ShowOrder\ShowOrderUseCase;
use Database\Factories\OrderFactory;
use Database\Factories\UserFactory;

test( 'it show an order by id', function () {
    $user = UserFactory::new()->create();  // Cria o usuário
    $createdOrder = OrderFactory::new()->create(['user_id' => $user->id]);

    $useCase = new ShowOrderUseCase(new OrderRepository(new Order()));

    $response = $useCase->execute(
        new ShowOrderInputDto(
            order_id: $createdOrder->id
        )
    );
    expect($response)->toBeInstanceOf(ShowOrderOutputDto::class);
    expect($response->id)->toBe($createdOrder->id);
});
