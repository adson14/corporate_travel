<?php

namespace Domain\Order\Entities;

use Domain\Order\Enum\OrderStatusEnum;
use Domain\Share\MethodsMagicsTrait;
use Domain\Share\Validation;
use Domain\Share\ValueObjects\Uuid;
use Domain\User\Entities\UserEntity;

class OrderEntity
{
	use MethodsMagicsTrait;

	public function __construct(
		protected ?UserEntity $user,
		protected ?string $destiny,
		protected ?\DateTime $departureDate,
		protected ?\DateTime $returnDate,
		protected ?OrderStatusEnum $status = null,
		protected ?\DateTime $created_at = null,
		protected ?Uuid $id = null,
	) {
		$this->id = $this->id ?? Uuid::random();
		$this->status = $this->status ?? OrderStatusEnum::PENDING;
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

	public function approve(): void
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