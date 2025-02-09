<?php
use App\Models\Order;
use App\Models\User;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\UserRepository;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderInputDto;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderOutputDto;
use Application\UseCases\Order\InsertOrder\InsertOrderUseCase;
use Database\Factories\UserFactory;

test( 'it create a new order', function () {
    $userCreated = UserFactory::new()->withPassword('senha_personalizada')->create(['password' => 12345678]);

    $useCase = new InsertOrderUseCase(new OrderRepository(new Order()), new UserRepository(new User()));
    $response = $useCase->execute(
        new InsertOrderInputDto(
            user_id: $userCreated->id,
            destiny: 'Australia',
            departure_date: '2028-01-01',
            return_date: '2029-01-02',
        )
    );
    expect($response)->toBeInstanceOf(InsertOrderOutputDto::class);
    $this->assertDatabaseHas('orders', [
        'id' => $response->id,
        'destiny' => 'Australia',
        'departure_date' => '2028-01-01',
        'return_date' => '2029-01-02',
        'status_order' => 'PENDING',
    ]);
});
