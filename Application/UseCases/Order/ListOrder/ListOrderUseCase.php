<?php

namespace Application\UseCases\Order\ListOrder;

use Application\UseCases\Order\ListOrder\DTO\ListOrderInputDto;
use Application\UseCases\Order\ListOrder\DTO\ListOrderOutputDto;
use Application\UseCases\Share\DTO\DtoToArray;
use Application\UseCases\Share\Factory\MetaFactory;
use Domain\Order\Repositories\IOrderRepository;


class ListOrderUseCase
{
	public function __construct(
		private readonly IOrderRepository $orderRepository,
	){}

	public function execute(ListOrderInputDto $input): ListOrderOutputDto
	{
			$fields = [
				'user_id',
				'destiny',
				'departure_date',
				'return_date',
				'status_order',
				'created_at'
			];

			$filterPagination = DtoToArray::convert($input->filters ?? new \StdClass());
			$paginator = $this->orderRepository->all($filterPagination, $fields, $input->page);

			return new ListOrderOutputDto(
				orders: $paginator->items(),
				meta: MetaFactory::make($paginator)
			);
	}
}