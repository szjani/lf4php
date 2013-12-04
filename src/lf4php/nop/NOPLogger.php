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

namespace lf4php\nop;

use Exception;
use lf4php\Logger;

/**
 * @SuppressWarnings("unused")
 * @author Szurovecz János <szjani@szjani.hu>
 */
class NOPLogger implements Logger
{
    const NAME = 'NOP';

    private static $instance = null;

    /**
     * @return NOPLogger
     */
    public static function getNOPLogger()
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

    public function debug($format, $params = array(), Exception $e = null)
    {
    }

    public function error($format, $params = array(), Exception $e = null)
    {
    }

    public function info($format, $params = array(), Exception $e = null)
    {
    }

    public function trace($format, $params = array(), Exception $e = null)
    {
    }

    public function warn($format, $params = array(), Exception $e = null)
    {
    }

    public function isDebugEnabled()
    {
        return false;
    }

    public function isErrorEnabled()
    {
        return false;
    }

    public function isInfoEnabled()
    {
        return false;
    }

    public function isTraceEnabled()
    {
        return false;
    }

    public function isWarnEnabled()
    {
        return false;
    }
}
