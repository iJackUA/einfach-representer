<?php
namespace einfach\representer\test\data;

class Example1Representer
{
    use \einfach\representer\Representer;
    use \einfach\representer\serializer\JSON;
    use \einfach\representer\serializer\YAML;

    public function rules()
    {
        return [
            $this->property('title')
                ->rename('titleAs')
                ->def('Hi there!'),

            $this->property('author'),

            $this->property('status'),

            $this->property('pubDate')
                ->getter([$this, 'showDate'])
                ->setter([$this, 'extractDate'])
        ];
    }

    public function showDate($object, $attributeName)
    {
        return $object->$attributeName->format('Y-m-d');
    }

    public function extractDate($object, $attributeName, $value)
    {
        return \DateTime::createFromFormat('Y-m-d', $value);
    }
}
