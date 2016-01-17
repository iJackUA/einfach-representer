<?php
namespace enzyme\representer\test;

class YamlSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testSerialization()
    {
        $mock = $this->getMockForTrait(\enzyme\representer\serializer\YAML::class);

        $mock->expects($this->any())
            ->method('getRepresentation')
            ->will($this->returnValue(['a' => 'b']));

        $this->assertEquals($mock->toYAML(), "a: b\n");
    }
}

