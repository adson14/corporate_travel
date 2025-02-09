<?php

namespace Application\UseCases\Order\ListOrder\DTO;

use Application\UseCases\Share\DTO\PaginationDto;

class ListOrderOutputDto
{
	public function __construct(
		public array $orders,
		public PaginationDto $meta
	)
	{}
}