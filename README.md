lf4php
======

This is a logging facade library. It wraps and hides logging frameworks thus you can whenever switch to another one. The idea came from slf4j which is a Java solution.

Features
--------

There is one implementation shipped with this package, the NOPLoggerFactory. It doesn't do anything :) Messages can be formatted by Mustache.

Currently there is one 'real' binding implementation: [lf4php/lf4php-monolog](https://github.com/szjani/lf4php-monolog)

Feel free to implement a binding for your preferred loggin framework.

Using lf4php
------------

```php
<?php
LoggerFactory::setILoggerFactory(new NOPLoggerFactory());

$logger = LoggerFactory::getLogger('test1');
$logger->info('Message');
$logger->debug('Hello {{name}}!', array('name' => 'John'));
$logger->error(new \Exception());
```
