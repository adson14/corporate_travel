<?php

namespace Domain\Order\Enum;

enum OrderStatusEnum: string
{
	case PENDING = 'PENDING';
	case APPROVED = 'APPROVED';
	case CANCELED = 'CANCELED';

	public function toString(): string
	{
			return match ($this) {
				self::PENDING => 'Solicitado',
				self::APPROVED => 'Aprovado',
				self::CANCELED => 'Cancelado',
			};
	}

	public static function toArray(): array
	{
		$array = [];
		foreach (self::cases() as $case) {
			$array[$case->value] = $case->toString();
		}
		return $array;
	}
}