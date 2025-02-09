<?php

namespace Application\UseCases\Share\DTO;

class PaginationDto
{

	public function __construct(
		public int $total,
		public int $per_page,
		public ?int $current_page = null,
		public ?int $last_page = null,
		public ?int $first_page = null,
		public ?int $to = null,
		public ?int $from = null
	){}
}