<?php
namespace einfach\representer\test;

use einfach\representer\test\data\Example1;
use einfach\representer\test\data\Example1Representer2;

class ClassRepresenter2Test extends \PHPUnit_Framework_TestCase
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

    public function testProjection()
    {
        $projection = Example1Representer2::one($this->target)->toArray();

        $this->assertNotEmpty($projection);

        $this->assertEquals($projection['titleAs'], $this->target->title);
        $this->assertEquals($projection['status'], $this->target->status);
        $this->assertEquals($projection['statusPlusOne'], $this->target->status + 1);
        $this->assertEquals($projection['pubDate'], $this->target->pubDate->format('Y-m-d'));
    }

    public function testRestore()
    {
        $projection = Example1Representer2::one($this->target)->toArray();

        $post = Example1Representer2::restore(Example1::class)->fromArray($projection);

        $this->assertInstanceOf(Example1::class, $post);
        print_r($post);
        $this->assertEquals($post->title, $this->target->title);
        $this->assertEquals($post->status, $this->target->status);
        $this->assertEquals($post->pubDate, $this->target->pubDate);

        $this->assertObjectNotHasAttribute('statusPlusOne', $post);
    }

}
