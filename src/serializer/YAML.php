<?php
namespace einfach\representer\serializer;

use Symfony\Component\Yaml\Yaml as YamlDumper;

/**
 * Class JSON
 *
 * @package einfach\representer\serializer
 *
 */
trait YAML
{
    public function toYAML()
    {
        return YamlDumper::dump($this->getRepresentation());
    }

    public function fromYAML($string)
    {
        //TBD
    }

    protected abstract function getRepresentation();
}
