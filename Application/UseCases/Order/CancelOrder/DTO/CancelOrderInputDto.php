<?php

namespace Application\UseCases\Order\CancelOrder\DTO;

class CancelOrderInputDto
{
	public function __construct(
		public string $order_id,
	){}
}