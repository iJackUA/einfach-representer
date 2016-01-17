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
    protected $object;
    /**
     * Strategy idicator
     * 0 = restore
     * 1 = one
     * 2 = collection
     *
     * @var string
     */
    protected $strategy;

    public function __construct($object = null, $strategy = 0)
    {
        $this->object = $object;
        $this->strategy = $strategy;
    }

    public function rules()
    {
        return [];
    }

    /**
     * @param $name
     * @return PropertyRule
     */
    public function property($name)
    {
        return new PropertyRule($this->object, $name);
    }

    /**
     * Represent one instance
     *
     * @param $object
     * @return static
     */
    public static function one($object)
    {
        return new static($object, 1);
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
                throw new \Exception('Representer strategy not defined');
        }

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

    /**
     * @param $projection
     * @param $className
     */
    public static function restore($projection, $className)
    {
        $instance = new static();
        $rules = $instance->rules();
        $object = new $className();

        if (!empty($rules)) {
            foreach ($rules as $rule) {
                /** @var $rule PropertyRule */
                $resultArray = $rule->reverseCompile($projection);

                reset($resultArray);
                $key = key($resultArray);
                $value = $resultArray[$key];

                $object->$key = $value;
            }
        }
        return $object;
    }
}
