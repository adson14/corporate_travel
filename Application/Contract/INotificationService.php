<?php

namespace Application\Contract;

interface INotificationService
{
	public function save(string $id, string $message, string $email): void;
}