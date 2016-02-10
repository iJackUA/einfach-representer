<?php
namespace einfach\representer\test\data;

class PostWrappedRepresenter extends Post1Representer
{
    public function collectionWrapper()
    {
        return 'examplesCollection';
    }
}
