<?php

namespace Application\UseCases\Order\CancelOrder\DTO;

class CancelOrderOutputDto
{
	public function __construct(
		public string $message = ''
	)
	{}
}