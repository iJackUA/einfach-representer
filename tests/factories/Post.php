<?php
use einfach\representer\test\data\Post;
use einfach\representer\test\data\Author;
use einfach\representer\test\data\Comment;
use League\FactoryMuffin\Faker\Facade as Faker;

/** @var $fm \League\FactoryMuffin\FactoryMuffin */

$fm->define(Post::class)->setDefinitions(
    [
        'id' => Faker::randomDigit(),
        'title' => Faker::sentence(),
        'author_id' => "factory|" . Author::class,
        'status' => Faker::randomElement([1, 2, 3]),
        'pubDate' => Faker::dateTime()
    ]);