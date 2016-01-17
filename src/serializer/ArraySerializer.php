<?php
namespace enzyme\representer\serializer;

/**
 * Class ArraySerializer
 *
 * @package enzyme\representer\serializer
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
        //TBD
    }

    protected abstract function getRepresentation();
}
