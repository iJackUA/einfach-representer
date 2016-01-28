<?php
namespace einfach\representer\test;

use einfach\representer\test\data\Example1;
use einfach\representer\test\data\Example1Representer;
use einfach\representer\test\data\Example2Representer;

class CollectionWrapperTest extends \PHPUnit_Framework_TestCase
{
    public $collection;

    public function setUp()
    {
        $this->collection = [
            new Example1(),
            new Example1(),
            new Example1()
        ];
    }

    public function tearDown()
    {
        unset($this->collection);
    }

    public function testSerializationWithWrap()
    {
        $projection = Example2Representer::collection($this->collection)->toArray();

        $this->assertArrayHasKey('examplesCollection', $projection);
        $this->assertEquals(count($projection['examplesCollection']), count($this->collection));
    }

    public function testRestoreWithWrap()
    {
        $projection = Example2Representer::collection($this->collection)->toArray();
        $collection = Example2Representer::restoreCollection(Example1::class)->fromArray($projection);

        $this->assertEquals(count($collection), count($this->collection));
    }
}
