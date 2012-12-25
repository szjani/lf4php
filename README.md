lf4php
======

This is a logging facade library. It wraps and hides logging frameworks thus you can whenever switch to another one. The idea came from slf4j which is a Java solution.

Features
--------

There is one implementation shipped with this package, the NOPLoggerFactory. It doesn't do anything :) Messages can be formatted by Mustache.

Currently there are two 'real' binding implementations: [lf4php/lf4php-monolog](https://github.com/szjani/lf4php-monolog), [lf4php/lf4php-log4php](https://github.com/szjani/lf4php-log4php)

Feel free to implement a binding for your preferred logging framework.

Using lf4php
------------

```php
<?php
// You have to set a factory depending on your chosen framework.
LoggerFactory::setILoggerFactory(new NOPLoggerFactory());

// Most implementations support logging hierarchy. You can use __CLASS__ keyword to obtain a logger.
$logger = LoggerFactory::getLogger('\foo\bar');
$logger->info('Message');
$logger->debug('Hello {{name}}!', array('name' => 'John'));
$logger->error(new \Exception());
```
