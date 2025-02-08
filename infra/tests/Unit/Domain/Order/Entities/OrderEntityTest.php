<?php


use Database\Factories\UserFactory;
use Domain\Order\Entities\OrderEntity;
use Domain\Order\Enum\OrderStatusEnum;
use Domain\Share\Exceptions\EntityValidationException;
use Domain\User\Entities\UserEntity;
use Illuminate\Support\Facades\Date;

test('should be create an order object', function () {

    $user = UserFactory::new()->create();
    $userEntity = new UserEntity();

    $order = new OrderEntity(
      user: $userEntity::fromReadModel(
        email: $user->email,
        name: $user->name,
        id: $user->id
      ),
      destiny: 'São Paulo',
      departureDate: new Date(),
      returnDate: new Date(),
      status: OrderStatusEnum::PENDING
    );

    expect($order->user->name)->toBe($user->name);
    expect($order->status->value)->toBe('PENDING');
    expect($order)->toBeInstanceOf(OrderEntity::class);
});

test('should be approve an order', function () {
    $user = UserFactory::new()->create();
    $userEntity = new UserEntity();

    $order = new OrderEntity(
        user: $userEntity::fromReadModel(
            email: $user->email,
            name: $user->name,
            id: $user->id
        ),
        destiny: 'São Paulo',
        departureDate: new Date(),
        returnDate: new Date(),
        status: OrderStatusEnum::PENDING
    );

    $order->approve(OrderStatusEnum::APPROVED);
    expect($order->status->value)->toBe('APPROVED');
});

test('should be cancel an order', function () {
    $user = UserFactory::new()->create();
    $userEntity = new UserEntity();

    $order = new OrderEntity(
        user: $userEntity::fromReadModel(
            email: $user->email,
            name: $user->name,
            id: $user->id
        ),
        destiny: 'São Paulo',
        departureDate: new Date(),
        returnDate: new Date(),
        status: OrderStatusEnum::PENDING
    );

    $order->cancel();
    expect($order->status->value)->toBe('CANCELED');
});


test('should be  return exception when validation fail', function () {
    expect(function () {
        $user = UserFactory::new()->create();
        $userEntity = new UserEntity();
        $order = new OrderEntity(
            user: $userEntity::fromReadModel(
                email: $user->email,
                name: $user->name,
                id: $user->id
            ),
            destiny: null,
            departureDate: new Date(),
            returnDate: new Date(),
            status: OrderStatusEnum::PENDING
        );
    })->toThrow(EntityValidationException::class);
});
