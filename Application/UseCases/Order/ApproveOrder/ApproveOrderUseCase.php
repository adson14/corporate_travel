<?php

namespace Application\UseCases\Order\ApproveOrder;

use Application\Contract\IEventDispatcher;
use Application\UseCases\Order\ApproveOrder\DTO\ApproveOrderInputDto;
use Application\UseCases\Order\ApproveOrder\DTO\ApproveOrderOutputDto;
use Domain\Events\OrderApproveEvent;
use Domain\Order\Repositories\IOrderRepository;

class ApproveOrderUseCase
{
	public function __construct(
		private readonly IOrderRepository $orderRepository,
		private IEventDispatcher $eventDispatcher
	){}

	public function execute(ApproveOrderInputDto $input): ApproveOrderOutputDto
	{
			$order = $this->orderRepository->find($input->order_id);
			$order->approve();

			$this->orderRepository->update($order);

			$this->eventDispatcher->dispatch(
				new OrderApproveEvent(
					orderId: $input->order_id,
					email: $order->user->email,
					message: 'Sua solicitação foi aprovada.'
				)
			);

			return new ApproveOrderOutputDto(
				message: 'Order approved successfully'
			);
	}
}