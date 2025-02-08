<?php

namespace Domain\Share;

use Domain\Order\Enum\OrderStatusEnum;
use Domain\Share\Exceptions\EntityValidationException;

class Validation
{
	public static function notEmpty(mixed $value): void
	{
		if (empty($value)) {
			throw new EntityValidationException('Field cannot be empty');
		}
	}

	public static function toBeCanceled(string $value): void
	{
		if ($value == OrderStatusEnum::CANCELED->value || $value == OrderStatusEnum::APPROVED->value) {
			throw new EntityValidationException('Order cannot be canceled');
		}
	}

	public static function toBeApproved(string $value): void
	{
		if ($value == OrderStatusEnum::APPROVED->value || $value == OrderStatusEnum::CANCELED->value) {
			throw new EntityValidationException('Order cannot be approved');
		}
	}
}