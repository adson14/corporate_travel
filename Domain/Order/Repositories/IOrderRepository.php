<?php

namespace Domain\Order\Repositories;

use Domain\Order\Entities\OrderEntity;

interface IOrderRepository
{
	public function insert(OrderEntity $order): void;

	public function find(string $id): ?OrderEntity;
}