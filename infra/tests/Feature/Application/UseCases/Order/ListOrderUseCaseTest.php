<?php

use App\Models\BaseModel;
use App\Models\Order;
use App\Repositories\Eloquent\OrderRepository;
use Application\UseCases\Order\ListOrder\DTO\FilterOrderDto;
use Application\UseCases\Order\ListOrder\DTO\ListOrderInputDto;
use Application\UseCases\Order\ListOrder\DTO\ListOrderOutputDto;
use Application\UseCases\Order\ListOrder\ListOrderUseCase;
use Database\Factories\OrderFactory;
use Database\Factories\UserFactory;

test( 'it list orders', function () {
    $quant = 30;
    $user = UserFactory::new()->create();
    OrderFactory::new()->count($quant)->create(['user_id' => $user->id]);

    $useCase = new ListOrderUseCase(new OrderRepository(new Order()));

    $input = new ListOrderInputDto(
        page: 1,
    );

    $response = $useCase->execute($input);
    expect($response)->toBeInstanceOf(ListOrderOutputDto::class);
    expect($response->meta->total)->toBe($quant);
    expect($response->meta->per_page)->toBe(BaseModel::itemsPerPage());
    expect($response->orders)->not()->toBeEmpty();

});

test( 'it list orders with filters', function () {
    $quant = 30;
    $user = UserFactory::new()->create();
    OrderFactory::new()->count($quant)->create(['user_id' => $user->id]);
    $orderSpeified = OrderFactory::new()->withdestiny('Itaberaba')->create();

    $useCase = new ListOrderUseCase(new OrderRepository(new Order()));

    $input = new ListOrderInputDto(
        page: 1,
        filters: new FilterOrderDto(
            destiny: $orderSpeified->destiny
        )
    );
    $response = $useCase->execute($input);
    expect($response)->toBeInstanceOf(ListOrderOutputDto::class);
    expect($response->meta->total)->toBe(1);
    expect($response->meta->per_page)->toBe(BaseModel::itemsPerPage());
    expect($response->orders)->not()->toBeEmpty();

});
