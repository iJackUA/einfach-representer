<?php
namespace einfach\representer\serializer;

/**
 * Class JSON
 *
 * @package einfach\representer\serializer
 *
 */
trait JSON
{
    public function toJSON()
    {
        return json_encode($this->getRepresentation());
    }

    public function fromJSON($string)
    {
        $projection = json_decode($string, true);
        return $this->getReverseRepresentation($projection);
    }

    protected abstract function getRepresentation();

    protected abstract function getReverseRepresentation($projection);
}
