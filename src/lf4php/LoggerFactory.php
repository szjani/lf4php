<?php
declare(strict_types=1);

namespace lf4php;

use lf4php\ILoggerFactory;
use lf4php\nop\NOPLoggerFactory;
use lf4php\impl\StaticLoggerBinder;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class LoggerFactory
{
    /**
     * @var ILoggerFactory
     */
    protected static $iLoggerFactory;

    public static function init() : void
    {
        if (class_exists('lf4php\impl\StaticLoggerBinder')) {
            self::$iLoggerFactory = StaticLoggerBinder::$SINGLETON->getLoggerFactory();
        } else {
            self::$iLoggerFactory = new NOPLoggerFactory();
        }
    }

    private function __construct()
    {
    }

    /**
     * @return ILoggerFactory
     */
    public static function getILoggerFactory() : ILoggerFactory
    {
        return self::$iLoggerFactory;
    }

    /**
     * @param string $name
     * @return Logger
     */
    public static function getLogger(string $name) : Logger
    {
        return self::getILoggerFactory()->getLogger($name);
    }
}
LoggerFactory::init();
