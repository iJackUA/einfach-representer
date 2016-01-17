<?php
namespace einfach\representer;

class PropertyRule
{
    public $object;
    public $name;

    protected $toName;
    protected $defaultValue;
    protected $getterCallable;
    protected $setterCallable;

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

    public function getter($callable)
    {
        $this->getterCallable = $callable;
        return $this;
    }

    public function setter($callable)
    {
        $this->setterCallable = $callable;
        return $this;
    }

    public function compile()
    {
        $name = ($this->toName) ? $this->toName : $this->name;

        if (is_callable($this->getterCallable)) {
            $value = call_user_func($this->getterCallable, $this->object, $this->name);
        } else {
            $value = ($this->object->{$this->name}) ? $this->object->{$this->name} : $this->defaultValue;
        }

        return [$name => $value];
    }

    public function reverseCompile($projection)
    {
        $name = ($this->toName) ? $this->toName : $this->name;
        $value = $projection[$name];

        if (is_callable($this->setterCallable)) {
            $value = call_user_func($this->setterCallable, $this->object, $this->name, $value);
        }

        return [$name => $value];
    }
}
