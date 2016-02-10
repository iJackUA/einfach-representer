<?php
namespace einfach\representer\test;

use einfach\representer\test\data\Post1Representer;
use einfach\representer\test\data\Post;

class ClassRepresenterTest extends \PHPUnit_Framework_TestCase
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

    public function testProjection()
    {
        $projection = Post1Representer::one($this->target)->toArray();

        $this->assertNotEmpty($projection);

        $this->assertEquals($projection['titleAs'], $this->target->title);
        $this->assertEquals($projection['status'], $this->target->status);
        $this->assertEquals($projection['pubDate'], $this->target->pubDate->format('Y-m-d'));
    }

    public function testRestore()
    {
        $projection = Post1Representer::one($this->target)->toArray();

        $post = Post1Representer::restore(Post::class)->fromArray($projection);

        $this->assertInstanceOf(Post::class, $post);

        $this->assertEquals($post->title, $this->target->title);
        $this->assertEquals($post->status, $this->target->status);
        $this->assertEquals($post->pubDate->format('Y-m-d'), $this->target->pubDate->format('Y-m-d'));
    }

    public function testCollectionProjection()
    {
        $objCollection = [
            clone($this->target),
            clone($this->target),
            clone($this->target)
        ];
        $collProjection = Post1Representer::collection($objCollection)->toArray();

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
            $this->instance(Post::class),
            $this->instance(Post::class),
            $this->instance(Post::class)
        ];

        $collProjection = Post1Representer::collection($objCollection)->toArray();

        $restoredCollection = Post1Representer::restoreCollection(Post::class)->fromArray($collProjection);

        $this->assertEquals(count($objCollection), count($restoredCollection));

        foreach ($restoredCollection as $key => $object) {
            $this->assertEquals($objCollection[$key]->title, $object->title);
            $this->assertEquals($objCollection[$key]->status, $object->status);
            $this->assertEquals($objCollection[$key]->pubDate->format('Y-m-d'), $object->pubDate->format('Y-m-d'));
        }
    }

}
