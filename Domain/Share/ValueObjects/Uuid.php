<?php

namespace App\Domain\Share\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{

	public function __construct(protected string $value)
	{
		$this->ensureIsValidUuid($value);
	}

	public static function random() : self
	{
		return new self(RamseyUuid::uuid4()->toString());
	}

	public function __toString(): string
	{
		return $this->value;
	}

	private function ensureIsValidUuid(string $uuid): void
	{
		if (!RamseyUuid::isValid($uuid))
			throw  new InvalidArgumentException(sprintf( 'UUID "%s" is not valid', $uuid));
	}

}