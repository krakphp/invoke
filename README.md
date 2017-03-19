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
