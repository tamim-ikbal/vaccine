<?php

namespace App\Abstract;

use ReflectionClass;

abstract class DTO
{

    private ReflectionClass $reflection;

    public function __construct(array $args)
    {

        $this->reflection = new ReflectionClass($this);
        $properties = $this->reflection->getProperties();
        $this->setPropertyValues($properties, $args);
    }

    private function setPropertyValues(array $properties, array $args): void
    {
        if (method_exists($this, 'mapKeys')) {
            foreach ($this->mapKeys() as $propertyKey => $constructKey) {
                if (array_key_exists($constructKey, $args)) {
                    $args[$propertyKey] = $args[$constructKey];
                    unset($args[$constructKey]);
                }
            }
        }

        foreach ($properties as $property) {
            if (isset($args[$property->getName()])) {
                $property->setValue($this, $args[$property->getName()]);
            }
        }

    }

}
