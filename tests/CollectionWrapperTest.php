<?php
namespace einfach\representer\test;

use einfach\representer\test\data\Post;
use einfach\representer\test\data\PostWrappedRepresenter;

class CollectionWrapperTest extends \PHPUnit_Framework_TestCase
{
    use lib\FactoryLoader;

    public $collection;

    public function setUp()
    {
        $this->collection = [
            $this->instance(Post::class),
            $this->instance(Post::class),
            $this->instance(Post::class)
        ];
    }

    public function tearDown()
    {
        unset($this->collection);
    }

    public function testSerializationWithWrap()
    {
        $projection = PostWrappedRepresenter::collection($this->collection)->toArray();

        $this->assertArrayHasKey('examplesCollection', $projection);
        $this->assertEquals(count($projection['examplesCollection']), count($this->collection));
    }

    public function testRestoreWithWrap()
    {
        $projection = PostWrappedRepresenter::collection($this->collection)->toArray();
        $collection = PostWrappedRepresenter::restoreCollection(Post::class)->fromArray($projection);

        $this->assertEquals(count($collection), count($this->collection));
    }
}
