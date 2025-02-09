<?php

namespace Application\UseCases\Order\InsertOrder\DTO;

class InsertOrderOutputDto
{
	public function __construct(
		public string $id,
		public string $message = ''
	)
	{}
}