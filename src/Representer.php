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

    public function __construct($source, $strategy)
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

    /**
     * Return property name to wrap a collection representation
     * If `null` - no wrapper added
     * @return null | string
     */
    public function collectionWrapper()
    {
        return null;
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
     * @return static
     */
    public static function collection(array $array)
    {
        return new static($array, 2);
    }

    protected function getCollectionRepresentation()
    {
        if (is_array($this->source) && count($this->source) > 0) {
            $representation = array_map(function ($object) {
                return static::one($object)->getOneRepresentation();
            }, $this->source);

            if ($wrapperName = $this->collectionWrapper()) {
                return [$wrapperName => $representation];
            } else {
                return $representation;
            }
        }
    }

    protected function getOneRepresentation()
    {
        $rules = $this->rules();
        if (empty($rules)) {
            throw new \Exception("There are rules specified in " . static::class . " representer");
        }

        $represented = [];

        foreach ($rules as $rule) {
            /** @var $rule PropertyRule */
            $resultArray = $rule->compile();

            reset($resultArray);
            $key = key($resultArray);
            $value = $resultArray[$key];

            $represented[$key] = $value;
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
                throw new \Exception('Wrong representation strategy selected. Maybe you have accidentally
                called `toJSON` instead of `fromJSON`?');
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

    /**
     * @param string $className
     * @return static
     */
    public static function restoreCollection($className)
    {
        $instance = new static(null, 4);
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
        if (empty($rules)) {
            throw new \Exception("There are rules specified in " . static::class . " representer");
        }

        $target = new $this->targetClassName();

        foreach ($rules as $rule) {
            /** @var $rule PropertyRule */
            $resultArray = $rule->reverseCompile($projection);

            reset($resultArray);
            $key = key($resultArray);
            $value = $resultArray[$key];

            $target->$key = $value;
        }

        return $target;
    }

    protected function getCollectionReverseRepresentation($projectionArray)
    {
        if ($wrapperName = $this->collectionWrapper()) {
            if (!isset($projectionArray[$wrapperName])) {
                $siblingKeys = join(',', array_keys($projectionArray));
                throw new \Exception("Collection wrapper `{$wrapperName}` not found during restore
                (instead following keys found: {$siblingKeys} ). In " . static::class . " representer");
            }
            $projectionArray = $projectionArray[$wrapperName];
        }

        if (is_array($projectionArray) && count($projectionArray) > 0) {
            return array_map(function ($projection) {
                return static::restore($this->targetClassName)->getOneReverseRepresentation($projection);
            }, $projectionArray);
        }
    }
}
