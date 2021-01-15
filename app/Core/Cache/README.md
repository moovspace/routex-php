### Cache string, token
```php
use App\Core\Cache\Cache;

// File cache
$c = new Cache();

// Set in cache
echo $c->Set('123', json_encode(['id' => '123456789', 'data' => 'hello']));

// Get from cache
echo $c->Get('123');
```