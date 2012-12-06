<?php
/*
 * Copyright (c) 2012 Szurovecz János
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

use lf4php\ILoggerFactory;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class LoggerFactory
{
    public static $KNOWN_BINDINGS = array(
        'lf4php\Monolog\MonologLoggerFactory'
    );

    /**
     * @var ILoggerFactory
     */
    private static $iLoggerFactory;

    private function __construct()
    {
    }

    /**
     * Try to find a known binding.
     *
     * @throws RuntimeException More than one binding has been found
     */
    private static function findILoggerFactory()
    {
        $class = null;
        foreach (self::$KNOWN_BINDINGS as $bindingClass) {
            if (class_exists($bindingClass)) {
                if ($class !== null) {
                    throw new RuntimeException('More than one lf4php binding has been found. Set explicit one!');
                }
                $class = $bindingClass;
            }
        }
        if ($class === null) {
            return null;
        }
        $reflectionClass = new ReflectionClass($class);
        try {
            return $reflectionClass->newInstanceArgs();
        } catch (ReflectionException $e) {
            return null;
        }
    }

    /**
     * @param ILoggerFactory $iLoggerFactory
     */
    public static function setILoggerFactory(ILoggerFactory $iLoggerFactory)
    {
        self::$iLoggerFactory = $iLoggerFactory;
    }

    /**
     * @return ILoggerFactory
     */
    public static function getILoggerFactory()
    {
        if (self::$iLoggerFactory === null) {
            self::$iLoggerFactory = self::findILoggerFactory();
            if (self::$iLoggerFactory === null) {
                self::$iLoggerFactory = new helpers\NOPLoggerFactory();
            }
        }
        return self::$iLoggerFactory;
    }

    /**
     * @param string $name
     * @return Logger
     */
    public static function getLogger($name)
    {
        return self::getILoggerFactory()->getLogger($name);
    }
}
