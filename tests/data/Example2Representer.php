<?php
namespace einfach\representer\test\data;

class Example2Representer extends Example1Representer
{
    public function collectionWrapper()
    {
        return 'examplesCollection';
    }
}
