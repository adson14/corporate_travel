<?php

namespace Application\UseCases\Order\ApproveOrder\DTO;

class ApproveOrderOutputDto
{
	public function __construct(
		public string $message = ''
	)
	{}
}