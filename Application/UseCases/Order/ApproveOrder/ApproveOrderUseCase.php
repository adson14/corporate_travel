<?php

namespace Application\UseCases\Order\ApproveOrder;

use Application\UseCases\Order\ApproveOrder\DTO\ApproveOrderInputDto;
use Application\UseCases\Order\ApproveOrder\DTO\ApproveOrderOutputDto;
use Application\UseCases\Order\ApproveOrder\DTO\CancelOrderInputDto;
use Application\UseCases\Order\ApproveOrder\DTO\CancelOrderOutputDto;
use Domain\Order\Repositories\IOrderRepository;

class ApproveOrderUseCase
{
	public function __construct(
		private readonly IOrderRepository $orderRepository,
	){}

	public function execute(ApproveOrderInputDto $input): ApproveOrderOutputDto
	{
			$order = $this->orderRepository->find($input->order_id);
			$order->approve();

			$this->orderRepository->update($order);

			return new ApproveOrderOutputDto(
				message: 'Order approved successfully'
			);
	}
}