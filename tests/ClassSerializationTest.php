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


    public function testSerializationAsArray()
    {
        $projection = Example1Representer::one($this->target)->toArray();

        $this->assertEquals($projection['titleAs'], $this->target->title);
        $this->assertEquals($projection['status'], $this->target->status);
        $this->assertEquals($projection['pubDate'], $this->target->pubDate->format('Y-m-d'));
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
status: 1
pubDate: '{$this->target->pubDate->format('Y-m-d')}'
";

        $this->assertEquals($text, $yaml);
    }

}
