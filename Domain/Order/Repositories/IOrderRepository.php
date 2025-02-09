<?php

namespace Domain\Order\Repositories;

use Domain\Order\Entities\OrderEntity;
use Domain\Share\Repositories\IPagination;

interface IOrderRepository
{
	public function insert(OrderEntity $order): void;

	public function find(string $id): ?OrderEntity;

	public function all(array $params = [], array $fields = [], ?int $page = null): IPagination;
}