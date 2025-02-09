<?php

namespace Application\UseCases\Order\ListOrder\DTO;

class ListOrderInputDto
{
	public function __construct(
		public int $page = 1,
		public ?FilterOrderDto $filters = null
	){}
}