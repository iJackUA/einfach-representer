<?php
namespace einfach\representer\serializer;

/**
 * Class ArraySerializer
 *
 * @package einfach\representer\serializer
 *
 */
trait ArraySerializer
{
    public function toArray()
    {
        return $this->getRepresentation();
    }

    public function fromArray($array)
    {
        return $this->getReverseRepresentation($array);
    }

    protected abstract function getRepresentation();

    protected abstract function getReverseRepresentation($projection);
}
