<?php

namespace Application\UseCases\Order\ShowOrder\DTO;

class ShowOrderInputDto
{
	public function __construct(
		public string $order_id,
	){}
}