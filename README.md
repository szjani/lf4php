lf4php
======

master: [![Build Status](https://travis-ci.org/szjani/lf4php.png?branch=master)](https://travis-ci.org/szjani/lf4php)
3.0: [![Build Status](https://travis-ci.org/szjani/lf4php.png?branch=3.0)](https://travis-ci.org/szjani/lf4php)
4.0: [![Build Status](https://travis-ci.org/szjani/lf4php.png?branch=4.0)](https://travis-ci.org/szjani/lf4php)

The Logging Facade for PHP (lf4php) serves as a simple facade or abstraction for various logging frameworks. Its design comes from [slf4j](http://www.slf4j.org).

Hello World
-----------

```php
$logger = LoggerFactory::getLogger(HelloWorld::class);
// or $logger = LoggerFactory::getLogger("The\Namespace\Of\HelloWorld");
$logger->info("Hello World");
```

This code snippet does not do anything. To resolve the problem, you have to use a logging framework and the appropriate lf4php binding. Assuming you use Monolog and Composer,
you need to pull the following dependencies:

* lf4php/lf4php
* lf4php/lf4php-monolog

Typical usage pattern
---------------------

```php
class Wombat
{
    private $t;
    private $oldT;

    public function setTemperature($temperature)
    {
        $logger = LoggerFactory::getLogger(Wombat::class);
        $this->oldT = $this->t;
        $this->t = $temperature;

        $logger->debug("Temperature set to {}. Old temperature was {}.", [$this->t, $this->oldT]);

        if ($temperature > 50) {
            $logger->info("Temperature has risen above 50 degrees.");
        }
    }
}
```

If a class extends `precore\lang\Object`, you can obtain the proper logger object via `self::getLogger()` method call.

Bindings
--------

* [lf4php/lf4php-log4php](https://github.com/szjani/lf4php-log4php)
* [lf4php/lf4php-monolog](https://github.com/szjani/lf4php-monolog)
* [lf4php/lf4php-psr3](https://github.com/szjani/lf4php-psr3)

lf4php-psr3 is a generic binding for any PSR-3 logging framework. However using specific bindings is recommended, because some features are missing from PSR-3 API.

Mapped Diagnostic Context (MDC) support
---------------------------------------

"Mapped Diagnostic Context" is essentially a map maintained by the logging framework where the application code provides key-value pairs which can then be inserted by the logging framework in log messages. MDC data can also be highly helpful in filtering messages or triggering certain actions.

lf4php supports MDC, or mapped diagnostic context. If the underlying logging framework offers MDC functionality, then lf4php will delegate to the underlying framework's MDC. Note that at this time, only log4php offers MDC functionality (and Monolog binding use a processor for it). If the underlying framework does not offer MDC, for example PSR-3, then lf4php will still store MDC data but the information therein will need to be retrieved by custom user code.

For example you can store user specific information in MDC. After that, log messages may contain these values depending on the configuration:

```php
// before the controller
MDC::put("userName", Session::getCurrentUser()->name());

// later, in the controller
$logger = LoggerFactory::getLogger(BasketController::class);
$logger->debug("Product added to basket: {}", [$basket]);
```

The log entry created in the controller may contains the user name too as additional information.

Static access to logger object
------------------------------

PSR-3 is a simple API, which does not support static access, you have to inject the logger objects. lf4php supports both static and injection ways.
The logger objects implement `lf4php\Logger` interface, they are actually instances of the adapter for the logging framework you use.

Logging hierarchy
-----------------

lf4php supports logging hierarchy even if the logging framework does not provide this feature. It means that when you are accessing to a logger object by a name,
lf4php assumes that the given string is a class or namespace and splits it at backslashes. After that it removes the last part of it until it finds a logger object
with the remaining, truncated name.

It is useful when you want to use a different logging configuration for a specific namespace or class. Assuming you use Monolog:

```php
// configuring Monolog loggers
$fooLogger = new \Monolog\Logger('foo');
$barLogger = new \Monolog\Logger('foo\bar');

$loggerFactory = StaticLoggerBinder::$SINGLETON->getLoggerFactory();
$loggerFactory->setRootMonologLogger($fooLogger);
$loggerFactory->registerMonologLogger($barLogger);
```

```php
namespace foo\bar;

class BarClass
{
    public function sayHello()
    {
        LoggerFactory::getLogger(BarClass::class)->info("hello");
    }
}
```

The above info log call will use the `$barLogger` object.

Location information
--------------------

It is really hard to identify the source of a log entry if it does not contain any information about it. Some frameworks like log4php
supports this feature, and can add the class or the file name to the messages, but Monolog and PSR-3 does not offer it. lf4php automatically prefixes
the messages with the location information all the time.

The output of the previous example would something like this:

```
[2015-01-04 13:18:43] foo\bar.INFO: f\b\BarClass - hello [] []
```

History
-------

### 4.2

 - Mapped (MDC) Diagnostic Contexts support. More information: http://logback.qos.ch/manual/mdc.html
 - There is a BC break around configuration. `LoggerFactory::setILoggerFactory()` has been removed, only one
  `lf4php\impl\StaticLoggerBinder` should be available provided by the binder.

### 4.1

 - Performance increased.
 - After an `lf4php\Logger` has been obtained for the first time, you cannot register more loggers. 

### 4.0

LazyMap (thanks Ocramius) has been introduced to store logger instances in `CachedClassLoggerFactory`. Its interface has been changed:
 - the root logger has to be passed to its constructor, the abstract `getDefaultLogger()` method has been removed
 - the `map` property became private
 - after calling the `getLogger()` method for the first time, no more logger can be registered, otherwise an `RuntimeException` is being thrown

### 3.0

Mustache based MessageFormatter has been modified to use slf4j style. For more information see the description above.
Thus Mustache is not a dependency anymore. Now message formatting is more than 4 times faster and log lines are shorter.
