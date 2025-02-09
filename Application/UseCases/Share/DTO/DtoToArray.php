<?php

namespace Application\UseCases\Share\DTO;

class DtoToArray
{
	/**
	 * Converte um objeto DTO em array.
	 *
	 * @param object $dto
	 * @return array
	 */
	public static function convert(object $dto): array
	{
		$reflectionClass = new \ReflectionClass($dto);
		$properties = $reflectionClass->getProperties();

		$array = [];

		foreach ($properties as $property) {
			$property->setAccessible(true);
			$array[$property->getName()] = $property->getValue($dto);
		}

		return $array;
	}
}