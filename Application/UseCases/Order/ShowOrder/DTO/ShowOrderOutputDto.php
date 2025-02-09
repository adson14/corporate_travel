<?php

namespace Application\UseCases\Order\ShowOrder\DTO;

class ShowOrderOutputDto
{
	public function __construct(
		public string $id,
		public string $user_id,
		public string $user_name,
		public string $destiny,
		public string $departure_date,
		public string $return_date,
		public string $status,
		public ?string $created_at
	)
	{}
}