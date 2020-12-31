# The HttpFoundation Component

First, if the name query parameter is not defined in the URL query string, you will get a PHP warning; 
so let’s fix it:

```php
// framework/index.php
$name = isset($_GET['name']) ? $_GET['name'] : 'World';

printf('Hello %s', $name);
```

...

## Going OOP with the HttpFoundation Component

To use this component, add it as a dependency of the project:

```bash
composer require symfony/http-foundation
```

Now, let’s rewrite our application by using the Request and the Response classes:

```php
// framework/index.php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$name = $request->get('name', 'World');

$response = new Response(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));

$response->send();
```

If you want to learn more about the HttpFoundation component, you can have a look at the 
Symfony\Component\HttpFoundation API or read its dedicated documentation:
<https://symfony.com/doc/4.4/components/http_foundation.html>
