<?php
namespace einfach\representer;

use einfach\representer\serializer\ArraySerializer;

/**
 * Trait Representer
 *
 * @package einfach\representer
 */
trait Representer
{
    use ArraySerializer;

    /**
     * Object that is being represented
     * or a collection handler
     */
    protected $source;
    /**
     * Class name to be restored
     *
     * @var string
     */
    protected $targetClassName;
    /**
     * Strategy indicator
     * 1 = one
     * 2 = collection
     * 3 = restore one
     * 4 = restore collection
     *
     * @var string
     */
    protected $strategy;

    public function __construct($source = null, $strategy)
    {
        if (is_null($strategy)) {
            throw new \Exception('Representer can not be initialized without a strategy param');
        }

        $this->source = $source;
        $this->strategy = $strategy;
    }

    public function rules()
    {
        return [];
    }

    public function setTargetClassName($name)
    {
        $this->targetClassName = $name;
    }

    /**
     * @param $name
     * @return PropertyRule
     */
    public function property($name)
    {
        return new PropertyRule($this->source, $name);
    }

    /**
     * Represent one instance
     *
     * @param $source
     * @return static
     */
    public static function one($source)
    {
        return new static($source, 1);
    }

    /**
     * Represent collection of instances
     *
     * @param array $array
     */
    public static function collection(array $array)
    {
        //TBD
    }

    protected function getCollectionRepresentation()
    {
        //TBD
        return ['collection', 'tbd'];
    }

    protected function getOneRepresentation()
    {
        $rules = $this->rules();
        $represented = [];

        if (!empty($rules)) {
            foreach ($rules as $rule) {
                /** @var $rule PropertyRule */
                $resultArray = $rule->compile();

                reset($resultArray);
                $key = key($resultArray);
                $value = $resultArray[$key];

                $represented[$key] = $value;
            }
        }

        return $represented;
    }

    protected function getRepresentation()
    {
        switch ($this->strategy) {
            case 1:
                return $this->getOneRepresentation();
            case 2:
                return $this->getCollectionRepresentation();
            default:
                throw new \Exception('Representation strategy not defined');
        }

    }


    /**
     * @param $className
     * @return static
     */
    public static function restore($className)
    {
        $instance = new static(null, 3);
        $instance->setTargetClassName($className);
        return $instance;
    }

    protected function getReverseRepresentation($projection)
    {
        switch ($this->strategy) {
            case 3:
                return $this->getOneReverseRepresentation($projection);
            case 4:
                return $this->getCollectionReverseRepresentation($projection);
            default:
                throw new \Exception('Reverse representation strategy not defined');
        }

    }

    protected function getOneReverseRepresentation($projection)
    {
        $rules = $this->rules();
        $target = new $this->targetClassName();

        if (!empty($rules)) {
            foreach ($rules as $rule) {
                /** @var $rule PropertyRule */
                $resultArray = $rule->reverseCompile($projection);

                reset($resultArray);
                $key = key($resultArray);
                $value = $resultArray[$key];
print_r($target);
                $target->$key = $value;
            }
        }
        return $target;
    }

    protected function getCollectionReverseRepresentation($projection)
    {
        //TBD
    }
}
