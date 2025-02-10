<?php

namespace Application\Handlers;

use Application\Contract\INotificationService;
use Domain\Events\OrderApproveEvent;

class ApproveOrderEventHandler
{
	public function __construct(private INotificationService $notificationService) {}

	public function handle(OrderApproveEvent $event): void
	{
		$this->notificationService->save(
			id: $event->orderId,
			message: $event->message,
			email: $event->email
		);
	}
}