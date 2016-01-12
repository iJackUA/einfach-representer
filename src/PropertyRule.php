<?php
namespace enzyme\representer;

class PropertyRule
{
    public $object;
    public $name;

    protected $toName;
    protected $defaultValue;
    protected $serializerCallable;

    public function __construct($object, $name)
    {
        $this->object = $object;
        $this->name = $name;
    }

    public function rename($toName)
    {
        $this->toName = $toName;
        return $this;
    }

    public function def($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function serializer($callable)
    {
        $this->serializerCallable = $callable;
        return $this;
    }

    public function compile()
    {
        $name = ($this->toName) ? $this->toName : $this->name;

        if (is_callable($this->serializerCallable)) {
            $value = call_user_func($this->serializerCallable, $this->object, $this->name);
        } else {
            $value = ($this->object->{$this->name}) ? $this->object->{$this->name} : $this->defaultValue;
        }

        return [$name => $value];
    }
}
