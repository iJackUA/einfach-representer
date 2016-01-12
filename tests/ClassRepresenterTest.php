<?php
namespace enzyme\representer\Test;

class Post
{
    public $title = 'Cool story bro';
    public $status = 1;
    public $pubDate;

    public function __construct()
    {
        $this->pubDate = new \DateTime();
    }
}

class PostRepresenter extends \enzyme\representer\Representer
{
    public function rules()
    {
        return [
            $this->property('title')
                ->rename('titleAs')
                ->def('Hi there!'),

            $this->property('status'),

            $this->property('pubDate')
                ->serializer([$this, 'showDate'])
            //->extractor([$this, 'extractDate'])
        ];
    }

    public function showDate($object, $attributeName)
    {
        return $object->$attributeName->format('Y-m-d');
    }

    public function extractDate($object, $attributeName, $value)
    {
        return $object->$attributeName = \DateTime::createFromFormat('Y-m-d', $value);
    }
}



class ClassRepresenterTest extends \PHPUnit_Framework_TestCase
{
    public $target;

    public function setUp()
    {
        $this->target = new Post();
    }

    public function tearDown()
    {
        unset($this->target);
    }

    public function testProjection()
    {
        $projection = PostRepresenter::one($this->target);

        $this->assertNotEmpty($projection);

        $this->assertEquals($projection['titleAs'], $this->target->title);
        $this->assertEquals($projection['status'], $this->target->status);
        $this->assertEquals($projection['pubDate'], $this->target->pubDate->format('Y-m-d'));
    }
}
