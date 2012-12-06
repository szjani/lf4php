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

namespace lf4php\stdout;

use Exception;
use lf4php\helpers\MessageFormatter;
use lf4php\Logger;
use lf4php\nop\NOPLogger;

/**
 * @SuppressWarnings("unused")
 * @author Szurovecz János <szjani@szjani.hu>
 */
class StdoutLogger implements Logger
{
    const NAME = 'Stdout';

    private static $instance = null;

    /**
     * @return NOPLogger
     */
    public static function getStdoutLogger()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct()
    {
    }

    public function getName()
    {
        return self::NAME;
    }

    public function debug($format, $params = array())
    {
        echo MessageFormatter::format($format, $params) . PHP_EOL;
    }

    public function error($format, $params = array())
    {
        echo MessageFormatter::format($format, $params) . PHP_EOL;
    }

    public function info($format, $params = array())
    {
        echo MessageFormatter::format($format, $params) . PHP_EOL;
    }

    public function trace($format, $params = array())
    {
        $e = new Exception();
        echo MessageFormatter::format($format, $params) . PHP_EOL . $e->getTraceAsString() . PHP_EOL;
    }

    public function warn($format, $params = array())
    {
        echo MessageFormatter::format($format, $params) . PHP_EOL;
    }

    public function isDebugEnabled()
    {
        return true;
    }

    public function isErrorEnabled()
    {
        return true;
    }

    public function isInfoEnabled()
    {
        return true;
    }

    public function isTraceEnabled()
    {
        return true;
    }

    public function isWarnEnabled()
    {
        return true;
    }
}
