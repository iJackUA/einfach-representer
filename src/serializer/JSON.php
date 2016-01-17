<?php
namespace enzyme\representer\serializer;

/**
 * Class JSON
 *
 * @package enzyme\representer\serializer
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
        // TBD
    }

    protected abstract function getRepresentation();
}
