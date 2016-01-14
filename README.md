## Enzyme-Represesenter

[![Latest Version on Packagist][ico-version]][link-packagist] [![Software License][ico-license]](LICENSE.md) [![Build Status][ico-travis]][link-travis] [![Coverage Status][ico-scrutinizer]][link-scrutinizer] [![Quality Score][ico-code-quality]][link-code-quality] [![Total Downloads][ico-downloads]][link-downloads]

Proof of concept representer objects with chain syntax rules notation.
Performs object serialization and object restore.

Currently does not support nested values.

## Motivation

To have an object with representation logic that is able to convert complex object into array/string representation and vice versa. 
According to the same rules.
For example: serialize for AJAX data output and restore backend domain model on POST operation. 
To have representation free of persistency or domain logic.  
Or to use inside backend app for some kind of data mapping.


## Examples

See tests for the most recent version.

Assume some Object with data that could not be simply json-encoded
```php
class Post
{
    public $title = 'Cool story bro';
    public $status = 1;
    public $pubDate;

    public function __construct()
    {
        $this->pubDate = new \DateTime();
    }
}
```

Create `Representer` class with representation rules.
You can rename options, assing default value (in case if it will be null) and specify custom geter/setter

```php
class PostRepresenter
{
    use \enzyme\representer\Representer;

    public function rules()
    {
        return [
            $this->property('title')
                ->rename('titleAs')
                ->def('Hi there!'),

            $this->property('status'),

            $this->property('pubDate')
                ->getter([$this, 'showDate'])
                ->setter([$this, 'extractDate'])
        ];
    }

    public function showDate($object, $attributeName)
    {
        return $object->$attributeName->format('Y-m-d');
    }

    public function extractDate($object, $attributeName, $value)
    {
        return \DateTime::createFromFormat('Y-m-d', $value);
    }
}
```

## Representation

```php
$post = new Post();
$projection = PostRepresenter::one($post)->toArray();
```


## Restore object from representation 

Restoring object from presentation array data

```php
$restoredPost = PostRepresenter::restore($projection, Post::class);
```

## Serialization

You can serialize object directly to JSON or YAML.
Serialization ability should be added via corresponding Trait

```php
class PostRepresenter
{
    use \enzyme\representer\Representer;
    use \enzyme\representer\serializer\JSON;
    ....
}

$projection = PostRepresenter::one($post)->toJSON();
```

```php
class PostRepresenter
{
    use \enzyme\representer\Representer;
    use \enzyme\representer\serializer\YAML;
    ....
}

$projection = PostRepresenter::one($post)->toYAML();
```



## TODO Ideas: 

* ~~Traits composition (Representers not inherited, but added via Traits)~~
* ~~Serialisation/de-serialisation (`toJSON`, `toYAML`)~~
* De-serialisation (`fromJSON`, `fromYAML`)
* Inverse property declaration (to allow any property name in projection, not coupled with source)
* Property rules: render_null  (Manage default? Example `rename: function($object, $attr) { return uppercase($attr); } `)
* Property decoration/Nested serialization (`->representer(ArtistRepresenter::class)->class(Artist::class)`)
* Nested properties `->property('artist')->nested([ $this->property('films')->..., $this->property('name')->... ])` 
* Collection representation `::collection` and `->collection()` 
* Wrapping collections `->wrap('items')` and `->removeWrap()` for `->collection()`
* Ability for "array to array" and "object to object" representations
* Coersion (`->int`, `->float`, `->string`). A way to coerce complex types/classes, DateTime?
* External options in `::one`, `::collection` (should be passed to all $callables)
* Check that Representer inheritance overwrites rules (try to do partial overwrite with `->inherit(true)`)
* Try to do Representer mixins (via Traits?)


## Credits

- [Ievgen Kuzminov][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/enzyme/representer.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/enzyme/representer/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/enzyme/representer.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/enzyme/representer.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/enzyme/representer.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/enzyme/representer
[link-travis]: https://travis-ci.org/enzyme/representer
[link-scrutinizer]: https://scrutinizer-ci.com/g/enzyme/representer/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/enzyme/representer
[link-downloads]: https://packagist.org/packages/enzyme/representer
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
