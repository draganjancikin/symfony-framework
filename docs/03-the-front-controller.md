# The Front Controller

Add another page that says goodbye:

```php
// framework/bye.php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$response = new Response('Goodbye!');
$response->send();
```

Much of the code is exactly the same as the one we have written for the first page.
The PHP way of doing the refactoring would probably be the creation of an include file:

```php
// framework/init.php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();
```

```php
// framework/index.php
require_once __DIR__.'/init.php';

$name = $request->get('name', 'World');

$response->setContent(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));
$response->send();
```

```php
// framework/bye.php
require_once __DIR__.'/init.php';

$response->setContent('Goodbye!');
$response->send();
```

Routing all client requests to a single PHP script:

```php
// framework/front.php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();

$map = [
    '/hello' => __DIR__.'/hello.php',
    '/bye'   => __DIR__.'/bye.php',
];

$path = $request->getPathInfo();
if (isset($map[$path])) {
    require $map[$path];
} else {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}

$response->send();
```

```php
// framework/hello.php
$name = $request->get('name', 'World');
$response->setContent(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));
```

Now that the web server always accesses the same script (front.php) for all pages, we can secure the code 
further by moving all other PHP files outside the web root directory:

```bash
example.com
├── composer.json
├── composer.lock
├── src
│   └── pages
│       ├── hello.php
│       └── bye.php
├── vendor
│   └── autoload.php
└── web
    └── front.php
```

The last thing that is repeated in each page is the call to setContent(). We can convert all pages to 
“templates” by just echoing the content and calling the setContent() directly from the front controller 
script:

```php
// example.com/web/front.php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();

$map = [
    '/hello' => __DIR__.'/../src/pages/hello.php',
    '/bye'   => __DIR__.'/../src/pages/bye.php',
];

$path = $request->getPathInfo();
if (isset($map[$path])) {
    ob_start();
    include $map[$path];
    $response->setContent(ob_get_clean());
} else {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}

$response->send();
```

```php
<!-- example.com/src/pages/hello.php -->
<?php $name = $request->get('name', 'World') ?>

Hello <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>
```

If you decide to stop here, you can probably enhance your framework by extracting the URL map to a 
configuration file.
