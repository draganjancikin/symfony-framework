# Introduction
<https://symfony.com/doc/4.4/create_framework/introduction.html>

## Why would you Like to Create your Own Framework?

* To learn more about the low level architecture of modern web frameworks in general and about the Symfony 
full-stack framework internals in particular
* To experiment creating a framework for fun (in a learn-and-throw-away approach)
* To refactor an old/existing application that needs a good dose of recent web development best practices
* To prove the world that you can actually create a framework on your own (… but with little effort)

This tutorial won’t talk about the MVC pattern, as the Symfony Components are able to create any type of 
frameworks, not just the ones that follow the MVC architecture. Anyway, if you have a look at the MVC 
semantics, this book is about how to create the Controller part of a framework. For the Model and the View, 
it really depends on your personal taste and you can use any existing third-party libraries (Doctrine, 
Propel or plain-old PDO for the Model; PHP or Twig for the View).

The fundamental principles of the Symfony Components are focused on the HTTP specification. As such, the 
framework that you are going to create should be more accurately labelled as a HTTP framework or 
Request/Response framework.

## Before You Start

You need:
* PHP 5.5.9 or later
* web server (like Apache, nginx or PHP’s built-in web server)
* good knowledge of PHP and an understanding of Object Oriented programming

## Bootstrapping

To store your new framework, create a directory.

### Dependency Management

To install the Symfony Components that you need for your framework, you are going to use Composer.
```php
composer init
```

## Our Project

Let’s start with the simplest web application we can think of in PHP:

```php
// framework/index.php
$name = $_GET['name'];

printf('Hello %s', $name);
```

You can use it with:  
http://local_server_name/index.php?name=Dragan
