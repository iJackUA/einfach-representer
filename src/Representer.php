<?php
namespace enzyme\representer;

/**
 * Class Representer
 *
 * @package enzyme\representer
 */
class Representer
{
    /**
     * Object that is being represented
     */
    public $object;

    public function __construct($object)
    {
        $this->object = $object;
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
     * @return string
     */
    public static function one($object)
    {
        $instance = new static($object);
        $rules = $instance->rules();
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

    /**
     * Represent collection of instances
     *
     * @param array $array
     */
    public static function collection(array $array)
    {
        //TBD
    }
}
