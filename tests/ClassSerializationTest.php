<?php
namespace einfach\representer\test;

use einfach\representer\test\data\Example1;
use einfach\representer\test\data\Example1Representer;

class ClassSerializationTest extends \PHPUnit_Framework_TestCase
{
    public $target;

    public function setUp()
    {
        $this->target = new Example1();
    }

    public function tearDown()
    {
        unset($this->target);
    }

    public function testSerializationAsJson()
    {
        $text = Example1Representer::one($this->target)->toJSON();

        $this->assertJson($text);
    }

    public function testSerializationAsYaml()
    {
        $text = Example1Representer::one($this->target)->toYAML();
        $yaml =
            "titleAs: 'Cool story bro'
author: 'Ievgen Kuzminov'
status: 1
pubDate: '{$this->target->pubDate->format('Y-m-d')}'
";

        $this->assertEquals($text, $yaml);
    }


    public function testDeserializationFromJson()
    {
        $json = '{"titleAs":"Cool story bro","author":"Ievgen Kuzminov","status":1,"pubDate":"2016-01-18"}';
        $object = Example1Representer::restore(Example1::class)->fromJSON($json);

        $this->assertInstanceOf(Example1::class, $object);
    }

    public function testDeserializationFromYaml()
    {
        $yaml =
            "titleAs: 'Cool story bro'
author: 'Ievgen Kuzminov'
status: 1
pubDate: '2016-01-18'
";
        $object = Example1Representer::restore(Example1::class)->fromYAML($yaml);

        $this->assertInstanceOf(Example1::class, $object);
    }

}
