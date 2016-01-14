<?php
namespace enzyme\representer\serializer;

/**
 * Class ArraySerializer
 *
 * @package enzyme\representer\serializer
 *
 * @method array getRepresentation()
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
}
