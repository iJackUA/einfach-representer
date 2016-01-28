<?php
namespace einfach\representer\test\lib;

use League\FactoryMuffin\FactoryMuffin;
use League\FactoryMuffin\Faker\Facade as Faker;

/**
 * Trait FactoriesLoader
 * @package einfach\representer\test\factories
 *
 * Add factories preload to test class
 *
 */
trait FactoryLoader
{
    protected static $fm;

    public static function setUpBeforeClass()
    {
        static::$fm = new FactoryMuffin();
        static::$fm->setSaveMethod(function ($object) {
            // we just do not save anything :)
            return true;
        });
        static::$fm->loadFactories(__DIR__ . '/../factories');
        Faker::setLocale('en_EN');
    }

    /**
     * Shortcut to create Factory Muffins
     * @param $className
     */
    protected function instance($className)
    {
        return static::$fm->instance($className);
    }
}