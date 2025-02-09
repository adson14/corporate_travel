<?php

namespace Application\UseCases\Order\InsertOrder;

use Application\UseCases\Order\InsertOrder\DTO\InsertOrderInputDto;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderOutputDto;
use Carbon\Carbon;
use Domain\Order\Entities\OrderEntity;
use Domain\Order\Repositories\IOrderRepository;
use Domain\User\Entities\UserEntity;

class InsertOrderUseCase
{
	public function __construct(
		private readonly IOrderRepository $orderRepository,
	){}

	public function execute(InsertOrderInputDto $input): InsertOrderOutputDto
	{

			$userEntity = new UserEntity();
			$order = new OrderEntity(
				user: $userEntity,
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