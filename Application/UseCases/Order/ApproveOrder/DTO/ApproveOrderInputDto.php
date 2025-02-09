<?php

namespace Application\UseCases\Order\ApproveOrder\DTO;

class ApproveOrderInputDto
{
	public function __construct(
		public string $order_id,
	){}
}