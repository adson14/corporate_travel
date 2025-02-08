<?php

namespace Domain\Share;

trait MethodsMagicsTrait
{
	public function __get($name)
	{
		if (isset($this->{$name}) || $this->{$name} === null)
			return $this->{$name};

		$className = get_class($this);
		throw new \Exception("Undefined property: {$className}::\${$name}");
	}
}