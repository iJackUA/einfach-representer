<?php

require 'vendor/autoload.php';

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


$post = new Post();

$projection = PostRepresenter::one($post);

// reverse usage idea
// $post = PostRepresenter::restore($projection, Post::class);

print_r($projection);
