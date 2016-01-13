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