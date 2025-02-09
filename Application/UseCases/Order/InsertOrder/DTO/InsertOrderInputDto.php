<?php

namespace Application\UseCases\Order\InsertOrder\DTO;

class InsertOrderInputDto
{
	public function __construct(
		public string $user_id,
		public string $destiny,
		public string $departure_date,
		public string $return_date,
	){}
}