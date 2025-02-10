<?php

namespace Domain\Events;

class OrderApproveEvent
{

	public function __construct(
		public readonly string $orderId,
		public readonly string $email,
		public readonly string $message
	) {}
}