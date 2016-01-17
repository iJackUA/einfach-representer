<?php
namespace einfach\representer\test;

class JsonSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testSerialization()
    {
        $mock = $this->getMockForTrait(\einfach\representer\serializer\JSON::class);

        $mock->expects($this->any())
            ->method('getRepresentation')
            ->will($this->returnValue(['a' => 'b']));

        $this->assertJson($mock->toJSON());
    }
}

