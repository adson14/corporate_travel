<?php

namespace App\Event;

use Application\Contract\IEventDispatcher;

class EventDispatcher implements IEventDispatcher
{

    private array $handlers = [];

    public function registerHandlers(string $eventClass, callable $handler): void
    {
        $this->handlers[$eventClass][] = $handler;
    }

    public function dispatch(object $event): void
    {
        $eventClass = get_class($event);

        if (!isset($this->handlers[$eventClass])) {
            return;
        }

        foreach ($this->handlers[$eventClass] as $handler) {
            $handler($event);
        }
    }
}
