<?php
namespace einfach\representer\test;

use einfach\representer\test\data\Post;
use einfach\representer\test\data\Post1Representer;

class ClassSerializationTest extends \PHPUnit_Framework_TestCase
{
    use lib\FactoryLoader;

    public $target;

    public function setUp()
    {
        $this->target = $this->instance(Post::class);
    }

    public function tearDown()
    {
        unset($this->target);
    }

    public function testSerializationAsJson()
    {
        $text = Post1Representer::one($this->target)->toJSON();

        $this->assertJson($text);
    }

    public function testSerializationAsYaml()
    {
        $text = Post1Representer::one($this->target)->toYAML();
        $yaml =
            "titleAs: '{$this->target->title}'
status: {$this->target->status}
pubDate: '{$this->target->pubDate->format('Y-m-d')}'
";

        $this->assertEquals($text, $yaml);
    }


    public function testDeserializationFromJson()
    {
        $json = '{"titleAs":"Cool story bro","status":1,"pubDate":"2016-01-18"}';
        $object = Post1Representer::restore(Post::class)->fromJSON($json);

        $this->assertInstanceOf(Post::class, $object);
    }

    public function testDeserializationFromYaml()
    {
        $yaml =
            "titleAs: 'Cool story bro'
status: 1
pubDate: '2016-01-18'
";
        $object = Post1Representer::restore(Post::class)->fromYAML($yaml);

        $this->assertInstanceOf(Post::class, $object);
    }

}
