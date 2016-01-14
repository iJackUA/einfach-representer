<?php
namespace enzyme\representer\test\data;

class Example1
{
    public $title = 'Cool story bro';
    public $status = 1;
    public $pubDate;

    public function __construct()
    {
        $this->pubDate = new \DateTime();
    }
}
