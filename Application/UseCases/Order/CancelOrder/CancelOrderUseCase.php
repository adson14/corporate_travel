<?php

namespace Application\UseCases\Order\CancelOrder;

use Application\UseCases\Order\CancelOrder\DTO\CancelOrderInputDto;
use Application\UseCases\Order\CancelOrder\DTO\CancelOrderOutputDto;
use Domain\Order\Repositories\IOrderRepository;

class CancelOrderUseCase
{
	public function __construct(
		private readonly IOrderRepository $orderRepository,
	){}

	public function execute(CancelOrderInputDto $input): CancelOrderOutputDto
	{
			$order = $this->orderRepository->find($input->order_id);
			$order->cancel();

			$this->orderRepository->update($order);

			return new CancelOrderOutputDto(
				message: 'Order cancelled successfully'
			);
	}
}