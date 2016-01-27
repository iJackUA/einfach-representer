<?php
namespace einfach\representer\test;

use einfach\representer\test\data\Example1;
use einfach\representer\test\data\Example1Representer;

class ClassRepresenterTest extends \PHPUnit_Framework_TestCase
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
        $projection = Example1Representer::one($this->target)->toArray();

        $this->assertNotEmpty($projection);

        $this->assertEquals($projection['titleAs'], $this->target->title);
        $this->assertEquals($projection['status'], $this->target->status);
        $this->assertEquals($projection['pubDate'], $this->target->pubDate->format('Y-m-d'));
    }

    public function testRestore()
    {
        $projection = Example1Representer::one($this->target)->toArray();

        $post = Example1Representer::restore(Example1::class)->fromArray($projection);

        $this->assertInstanceOf(Example1::class, $post);

        $this->assertEquals($post->title, $this->target->title);
        $this->assertEquals($post->status, $this->target->status);
        $this->assertEquals($post->pubDate, $this->target->pubDate);
    }

    public function testCollectionProjection()
    {
        $objCollection = [
            clone($this->target),
            clone($this->target),
            clone($this->target)
        ];
        $collProjection = Example1Representer::collection($objCollection)->toArray();

        $this->assertEquals(count($objCollection), count($collProjection));

        foreach ($collProjection as $key => $projection) {
            $this->assertEquals($objCollection[$key]->title, $projection['titleAs']);
            $this->assertEquals($objCollection[$key]->status, $projection['status']);
            $this->assertEquals($objCollection[$key]->pubDate->format('Y-m-d'), $projection['pubDate']);
        }
    }

    public function testCollectionRestore()
    {
        $objCollection = [
            clone($this->target),
            clone($this->target),
            clone($this->target)
        ];

        $collProjection = Example1Representer::collection($objCollection)->toArray();

        $restoredCollection = Example1Representer::restoreCollection(Example1::class)->fromArray($collProjection);

        $this->assertEquals(count($objCollection), count($restoredCollection));

        foreach ($restoredCollection as $key => $object) {
            $this->assertEquals($objCollection[$key]->title, $object->title);
            $this->assertEquals($objCollection[$key]->status, $object->status);
            $this->assertEquals($objCollection[$key]->pubDate, $object->pubDate);
        }
    }

}
