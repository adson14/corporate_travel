<?php

namespace App\Domain\Share;

use App\Domain\Share\Exceptions\EntityValidationException;

class EntityValidation
{
	public static function notEmpty(mixed $value): void
	{
		if (empty($value)) {
			throw new EntityValidationException('Field cannot be empty');
		}
	}
}