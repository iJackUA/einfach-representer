<?php
namespace enzyme\representer\serializer;

use Symfony\Component\Yaml\Yaml as YamlDumper;

/**
 * Class JSON
 *
 * @package enzyme\representer\serializer
 *
 * @method array getRepresentation()
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
}
