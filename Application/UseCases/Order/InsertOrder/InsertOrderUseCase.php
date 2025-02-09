<?php

namespace Application\UseCases\Order\InsertOrder;

use Application\UseCases\Order\InsertOrder\DTO\InsertOrderInputDto;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderOutputDto;
use Carbon\Carbon;
use Domain\Order\Entities\OrderEntity;
use Domain\Order\Repositories\IOrderRepository;
use Domain\User\Entities\UserEntity;
use Domain\User\Repositories\IUserRepository;

class InsertOrderUseCase
{
	public function __construct(
		private readonly IOrderRepository $orderRepository,
		private readonly IUserRepository $userRepository
	){}

	public function execute(InsertOrderInputDto $input): InsertOrderOutputDto
	{

			$userEntity = new UserEntity();
			$userDb = $this->userRepository->find($input->user_id);
			$user = $userEntity::fromReadModel(email: $userDb->email, name: $userDb->name, id: $userDb->id);
			$order = new OrderEntity(
				user: $user,
				destiny: $input->destiny,
				departureDate: (new Carbon($input->departure_date))->toDateTime(),
				returnDate: (new Carbon($input->return_date))->toDateTime(),
			);

			$this->orderRepository->insert($order);

			return new InsertOrderOutputDto(
				id: $order->id,
				message: 'Order created successfully.'
			);
	}
}