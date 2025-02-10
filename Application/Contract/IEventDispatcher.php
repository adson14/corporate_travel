<?php

namespace Application\Contract;

interface IEventDispatcher
{

	public function dispatch(object $event): void;

	public function registerHandlers(string $eventClass, callable $handler): void;
}