# Invoke

Simple abstractions for invoking functions with parameters.

## Installation

Install with composer at `krak/invoke`

## Usage

Each invoker implements the simple interface:

```php
<?php

interface Invoke {
    public function invoke($func, ...$args);
}
```

Here's a simple example of the default invoker which uses `call_user_func`.

```php
<?php

use Krak\Invoke;

function hello($arg) {
    echo "Hello {$arg}\n";
}

$invoke = new Invoke\CallableInvoke();
$invoke->invoke('hello', 'World');
```

### Container Invoke

```php
<?php

// some psr container
$container['service'] = function() {};
$invoke = Invoke\ContainerInvoke::create($container);
$invoke->invoke('service'); // will invoke the function returned from the container
$invoke->invoke('str_repeat', 'a', 10); // if not in container, will try to normally invoke
```

#### Container with Separator

In addition to just invoking services, you can invoke service object methods if you pass in a separator into the container factory method.

```php
<?php

$container['service'] = function() { return new ArrayObject([1]); };
$invoke = Invoke\ContainerInvoke::createWithSeparator($container, '@');
$invoke->invoke('service@count'); // retrieves the service and invokes the count method which outputs 1 in this case
```

### Method Invoke

```php
<?php

// this will invoke any object with the append method
$invoke = Invoke\MethodInvoke::create('append');

$data = new ArrayObject();
$invoke->invoke($data, 1);
$invoke->invoke($data, 2);
assert(count($data) == 2);
```
