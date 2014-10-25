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

namespace lf4php\helpers;

use lf4php\LoggerFactory;
use lf4php\nop\NOPLogger;
use PHPUnit_Framework_TestCase;
use RuntimeException;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class LoggingTest extends PHPUnit_Framework_TestCase
{
    public function testLoggingNoException()
    {
        $testLogger1 = LoggerFactory::getLogger('test1');
        $testLogger2 = LoggerFactory::getLogger('test2');
        self::assertSame($testLogger2, $testLogger1);
    }

    public function testIsAnyEnabled()
    {
        $logger = LoggerFactory::getLogger('any');
        self::assertFalse($logger->isDebugEnabled());
        self::assertFalse($logger->isErrorEnabled());
        self::assertFalse($logger->isInfoEnabled());
        self::assertFalse($logger->isTraceEnabled());
        self::assertFalse($logger->isWarnEnabled());
    }

    public function testGetName()
    {
        $logger = LoggerFactory::getLogger('any');
        self::assertEquals(NOPLogger::NAME, $logger->getName());
    }

    public function testCallLogMethods()
    {
        $logger = LoggerFactory::getLogger('any');
        $logger->debug(null);
        $logger->error(null);
        $logger->info(null);
        $logger->trace(null);
        $logger->warn(null);
        // no exception
        self::assertTrue(true);
    }
}
