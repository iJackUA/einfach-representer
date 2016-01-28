<?php
use League\FactoryMuffin\Faker\Facade as Faker;
use einfach\representer\test\data\Author;

/** @var $fm \League\FactoryMuffin\FactoryMuffin */

$fm->define(Author::class)->setDefinitions(
    [
        'id' => Faker::randomDigit(),
        'firstName' => Faker::firstName(),
        'lastName' => Faker::lastName(),
    ]);