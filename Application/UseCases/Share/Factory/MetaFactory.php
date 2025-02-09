<?php

namespace Application\UseCases\Share\Factory;

use Application\UseCases\Share\DTO\PaginationDto;
use Domain\Share\Repositories\IPagination;

class MetaFactory
{
	public static function make(IPagination $input) : PaginationDto
	{
		return new PaginationDto(
			total: $input->total(),
			per_page:  $input->perPage(),
			current_page: $input->currentPage(),
			last_page: $input->lastPage(),
			first_page: $input->firstPage(),
			to: $input->to(),
			from: $input->from()
		);
	}

}