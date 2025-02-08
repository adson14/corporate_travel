<?php

namespace Domain\Order\Entities;

use Domain\Order\Enum\OrderStatusEnum;
use Domain\Share\Validation;
use Domain\Share\ValueObjects\Uuid;
use Domain\User\Entities\UserEntity;
use Illuminate\Support\Facades\Date;

class OrderEntity
{

	public function __construct(
		protected UserEntity $user,
		protected string $destiny,
		protected Date $departureDate,
		protected Date $returnDate,
		protected OrderStatusEnum $status,
		protected ?Uuid $id = null,
	) {
		$this->id = $this->id ?? Uuid::random();
		$this->validate();
	}

	public function validate(): void
	{
		Validation::notEmpty($this->destiny);
		Validation::notEmpty($this->departureDate);
		Validation::notEmpty($this->returnDate);
		Validation::notEmpty($this->status);
		Validation::notEmpty($this->user);
	}

	public function approve(OrderStatusEnum $status): void
	{
		Validation::toBeApproved($this->status->value);
		$this->status = OrderStatusEnum::APPROVED;
	}

	public function cancel()
	{
		Validation::toBeCanceled($this->status->value);
		$this->status = OrderStatusEnum::CANCELED;
	}
}