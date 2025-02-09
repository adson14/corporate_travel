<?php

namespace Application\UseCases\Order\ListOrder\DTO;

class FilterOrderDto
{
	public function __construct(
			public ?string $destiny = null,
			public ?string $status = null,
		  public ?string $departure_date_ini = null,
		  public ?string $departure_date_end = null,
		  public ?string $return_date_ini = null,
		  public ?string $return_date_end = null
	){}
}