<?php
namespace einfach\representer\test\data;

class Example1Representer2
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

            $this->property('authorFirstName')
                ->getter([$this, 'getAuthorFirstName'])
                ->setter([$this, 'setAuthorFirstName']),

            $this->property('authorLastName')
                ->getter([$this, 'getAuthorLastName'])
                ->setter([$this, 'setAuthorLastName']),

            $this->property('status'),

            $this->property('statusPlusOne')->getter(function ($object, $attribute) {
                return $object->status + 1;
            }),

            $this->property('pubDate')
                ->getter([$this, 'showDate'])
                ->setter([$this, 'extractDate']),
        ];
    }

    /**
     * pubDate
     */


    public function showDate($object, $attributeName)
    {
        return $object->$attributeName->format('Y-m-d');
    }

    public function extractDate($object, $attributeName, $value)
    {
        return \DateTime::createFromFormat('Y-m-d', $value);
    }


    /**
     * author
     */

    public function getAuthorFirstName($object, $attributeName)
    {
        return explode(' ', $object->author)[0];
    }

    public function setAuthorFirstName($object, $attributeName, $value)
    {

    }

    public function getAuthorLastName($object, $attributeName)
    {
        return explode(' ', $object->author)[1];
    }

    public function setAuthorLastName($object, $attributeName, $value)
    {

    }


}
