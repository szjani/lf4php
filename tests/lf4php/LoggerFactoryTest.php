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

use PHPUnit_Framework_TestCase;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class LoggerFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testFindKnownBindingsMissing()
    {
        $factory = LoggerFactory::getILoggerFactory();
        self::assertInstanceOf('\lf4php\nop\NOPLoggerFactory', $factory);
    }

    /**
     * @test
     */
    public function shouldUseFoundILoggerFactory()
    {
        $factory = $this->getMock('\lf4php\ILoggerFactory');
        $loggerName = 'logger-name';
        LoggerFactoryChild::setILoggerFactory($factory);
        $factory
            ->expects(self::once())
            ->method('getLogger')
            ->with($loggerName);
        LoggerFactory::getLogger($loggerName);
        LoggerFactory::init();
    }
}

class LoggerFactoryChild extends LoggerFactory
{
    public static function setILoggerFactory(ILoggerFactory $loggerFactory)
    {
        static::$iLoggerFactory = $loggerFactory;
    }
}