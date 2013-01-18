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

use PHPUnit_Framework_TestCase;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class CachedClassLoggerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CachedClassLoggerFactory
     */
    private $factory;

    private $defaultLogger;

    public function setUp()
    {
        $this->factory = $this->getMock(__NAMESPACE__ . '\CachedClassLoggerFactory', array('getDefaultLogger'));
        $this->defaultLogger = $this->getMock(__NAMESPACE__ . '\Logger');
    }

    public function testGetNotRegisteredLogger()
    {
        $this->factory
            ->expects(self::once())
            ->method('getDefaultLogger')
            ->will(self::returnValue($this->defaultLogger));
        self::assertSame($this->defaultLogger, $this->factory->getLogger('notExists'));
    }

    public function testGetRegisteredLogger()
    {
        $logger = $this->getMock(__NAMESPACE__ . '\Logger');
        $this->factory->registerLogger(__NAMESPACE__, $logger);
        self::assertSame($logger, $this->factory->getLogger(__NAMESPACE__));
    }

    public function testGetParentLogger()
    {
        $logger = $this->getMock(__NAMESPACE__ . '\Logger');
        $this->factory->registerLogger(__NAMESPACE__, $logger);
        $this->factory
            ->expects(self::never())
            ->method('getDefaultLogger');
        self::assertSame($logger, $this->factory->getLogger(__CLASS__));
    }

    public function testGetFirstParentLogger()
    {
        $logger1 = $this->getMock(__NAMESPACE__ . '\Logger');
        $logger2 = $this->getMock(__NAMESPACE__ . '\Logger');
        $this->factory->registerLogger('foo', $logger1);
        $this->factory->registerLogger('foo\bar', $logger2);
        $this->factory
            ->expects(self::never())
            ->method('getDefaultLogger');
        self::assertSame($logger2, $this->factory->getLogger('foo\bar\test'));
        self::assertSame($logger1, $this->factory->getLogger('foo\another'));
    }
}
