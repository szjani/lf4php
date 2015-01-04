<?php
/*
 * Copyright (c) 2014 Janos Szurovecz
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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

    public static function init()
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
    public static function put($key, $value)
    {
        self::checkKey($key);
        self::checkMdcAdapter();
        self::$mdcAdapter->put($key, $value);
    }

    /**
     * @param string $key
     * @return string
     */
    public static function get($key)
    {
        self::checkKey($key);
        self::checkMdcAdapter();
        return self::$mdcAdapter->get($key);
    }

    /**
     * @param string $key
     */
    public static function remove($key)
    {
        self::checkKey($key);
        self::checkMdcAdapter();
        self::$mdcAdapter->remove($key);
    }

    public static function clear()
    {
        self::checkMdcAdapter();
        self::$mdcAdapter->clear();
    }

    /**
     * @return array|null
     */
    public static function getCopyOfContextMap()
    {
        self::checkMdcAdapter();
        return self::$mdcAdapter->getCopyOfContextMap();
    }

    /**
     * @param array $contextMap
     */
    public static function setContextMap(array $contextMap)
    {
        self::checkMdcAdapter();
        self::$mdcAdapter->setContextMap($contextMap);
    }

    /**
     * @return MDCAdapter
     */
    public static function getMDCAdapter()
    {
        return self::$mdcAdapter;
    }

    private static function checkMdcAdapter()
    {
        if (self::$mdcAdapter === null) {
            throw new \RuntimeException('lf4php MDC adapter is null');
        }
    }

    private static function checkKey($key)
    {
        if ($key === null) {
            throw new InvalidArgumentException('The $key cannot be null');
        }
    }
}
MDC::init();
