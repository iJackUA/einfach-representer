## Enzyme-Represesenter

Proof of concept representer objects with chain syntax rules notation.
Performs object serialization and object restore.

Currently does not support nested values.

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
class PostRepresenter extends \enzyme\representer\Representer
{
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
        return $object->$attributeName = \DateTime::createFromFormat('Y-m-d', $value);
    }
}
```

Create presentation array from object

```php
$post = new Post();
$projection = PostRepresenter::one($post);
```

Restoring object from presentation array data

```php
$restoredPost = PostRepresenter::restore($projection, Post::class);
```


## TODO Ideas: 

* Inverse property declaration (to allow any property name in projection, not coupled with source)
* Property rules: render_null  (Manage default? Example `rename: function($object, $attr) { return uppercase($attr); } `)
* Property decoration/Nested serialization (`->representer(ArtistRepresenter::class)->class(Artist::class)`)
* Nested properties `->property('artist')->nested([ $this->property('films')->..., $this->property('name')->... ])` 
* Collection representation `::collection` and `->collection()` 
* Wrapping collections `->wrap('items')` and `->removeWrap()` for `->collection()`
* Array to array representation
* Coersion (`->int`, `->float`, `->string`). A way to coerce complex types/classes, DateTime?
* Traits composition (Representers not inherited, but added via Traits)
* External options in `::one`, `::collection` (should be passed to all $callables)
* Serialisation/de-serialisation (`RepresenterResponse` , `to_json`, `to_yaml`, `from_json`, `from_yaml`, `xml` ?)
* Check that Representer inheritance overwrites rules (try to do partial overwrite with `->inherit(true)`)
* Try to do Representer mixins (via Traits?)

