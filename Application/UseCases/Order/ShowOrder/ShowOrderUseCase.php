<?php

namespace Application\UseCases\Order\ShowOrder;

use Application\UseCases\Order\ShowOrder\DTO\ShowOrderInputDto;
use Application\UseCases\Order\ShowOrder\DTO\ShowOrderOutputDto;
use Domain\Order\Repositories\IOrderRepository;


class ShowOrderUseCase
{
	public function __construct(
		private readonly IOrderRepository $orderRepository,
	){}

	public function execute(ShowOrderInputDto $input): ShowOrderOutputDto
	{
			$order = $this->orderRepository->find($input->order_id);
			return new ShowOrderOutputDto(
				id: $order->id,
				user_id: $order->user->id,
				user_name: $order->user->name,
				destiny: $order->destiny,
				departure_date: $order->departureDate->format('Y-m-d'),
				return_date: $order->returnDate->format('Y-m-d'),
				status: $order->status->value,
				created_at: $order->created_at->format('Y-m-d H:i:s')
			);
	}
}