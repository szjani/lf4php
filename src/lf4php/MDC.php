<?php
declare(strict_types=1);

namespace lf4php;

use InvalidArgumentException;
use lf4php\helpers\BasicMDCAdapter;
use lf4php\impl\StaticMDCBinder;
use lf4php\spi\MDCAdapter;

/**
 * This class hides and serves as a substitute for the underlying logging
 * system's MDC implementation.
 *
 * @package lf4php
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class MDC
{
    /**
     * @var MDCAdapter
     */
    protected static $mdcAdapter;

    public static function init() : void
    {
        if (class_exists('lf4php\impl\StaticMDCBinder')) {
            self::$mdcAdapter = StaticMDCBinder::$SINGLETON->getMDCA();
        } else {
            self::$mdcAdapter = new BasicMDCAdapter();
        }
    }

    /**
     * @param string $key
     * @param string $value
     */
    public static function put(string $key, string $value) : void
    {
        self::checkKey($key);
        self::checkMdcAdapter();
        self::$mdcAdapter->put($key, $value);
    }

    /**
     * @param string $key
     * @return string
     */
    public static function get(string $key) : string
    {
        self::checkKey($key);
        self::checkMdcAdapter();
        return self::$mdcAdapter->get($key);
    }

    /**
     * @param string $key
     */
    public static function remove(string $key) : void
    {
        self::checkKey($key);
        self::checkMdcAdapter();
        self::$mdcAdapter->remove($key);
    }

    public static function clear() : void
    {
        self::checkMdcAdapter();
        self::$mdcAdapter->clear();
    }

    /**
     * @return array|null
     */
    public static function getCopyOfContextMap() : ?array
    {
        self::checkMdcAdapter();
        return self::$mdcAdapter->getCopyOfContextMap();
    }

    /**
     * @param array $contextMap
     */
    public static function setContextMap(array $contextMap) : void
    {
        self::checkMdcAdapter();
        self::$mdcAdapter->setContextMap($contextMap);
    }

    /**
     * @return MDCAdapter
     */
    public static function getMDCAdapter() : MDCAdapter
    {
        return self::$mdcAdapter;
    }

    private static function checkMdcAdapter() : void
    {
        if (self::$mdcAdapter === null) {
            throw new \RuntimeException('lf4php MDC adapter is null');
        }
    }

    private static function checkKey(string $key) : void
    {
        if ($key === null) {
            throw new InvalidArgumentException('The $key cannot be null');
        }
    }
}
MDC::init();
