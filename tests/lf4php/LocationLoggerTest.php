<?php
/*
 * Copyright (c) 2012 Janos Szurovecz
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

use Exception;
use PHPUnit_Framework_TestCase;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class LocationLoggerTest extends PHPUnit_Framework_TestCase
{
    private $logger;

    public function setUp()
    {
        $this->logger = new LocationLoggerMock();
    }

    public function testGetLocation()
    {
        self::assertEquals(__CLASS__, $this->logger->debug('test'));
    }

    public function testGetShortLocation()
    {
        self::assertEquals('l\LocationLoggerTest', $this->logger->info('test'));
    }
}

class LocationLoggerMock extends LocationLogger
{
    public function debug($format, $params = array(), Exception $e = null)
    {
        return $this->getLocation();
    }

    public function error($format, $params = array(), Exception $e = null)
    {

    }

    public function getName()
    {

    }

    public function info($format, $params = array(), Exception $e = null)
    {
        return $this->getShortLocation();
    }

    public function isDebugEnabled()
    {

    }

    public function isErrorEnabled()
    {

    }

    public function isInfoEnabled()
    {

    }

    public function isTraceEnabled()
    {

    }

    public function isWarnEnabled()
    {

    }

    public function trace($format, $params = array(), Exception $e = null)
    {

    }

    public function warn($format, $params = array(), Exception $e = null)
    {

    }
}
