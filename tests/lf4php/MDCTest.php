<?php
/*
 * Copyright (c) 2014 Szurovecz János
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

use lf4php\spi\MDCAdapter;
use PHPUnit_Framework_TestCase;

/**
 * Class MDCTest
 *
 * @package lf4php
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class MDCTest extends PHPUnit_Framework_TestCase
{
    const A_KEY = 'key1';
    const A_VALUE = 'value1';

    private $adapter;
    private $aContextMap;

    protected function setUp()
    {
        $this->adapter = $this->getMock('\lf4php\spi\MDCAdapter');
        $this->aContextMap = array(self::A_KEY, self::A_VALUE);
        MDCChild::setMDCAdapter($this->adapter);
    }

    /**
     * @test
     */
    public function shouldReturnNOPMDCAdapter()
    {
        MDCChild::reset();
        MDC::init();
        self::assertInstanceOf('\lf4php\helpers\NOPMDCAdapter', MDC::getMDCAdapter());
    }

    /**
     * @test
     */
    public function shouldPutToAdapter()
    {
        $this->adapter
            ->expects(self::once())
            ->method('put')
            ->with(self::A_KEY, self::A_VALUE);
        MDC::put(self::A_KEY, self::A_VALUE);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldPutFailIfKeyIsNull()
    {
        MDC::put(null, self::A_VALUE);
    }

    /**
     * @test
     */
    public function shouldGetFromAdapter()
    {
        $this->adapter
            ->expects(self::once())
            ->method('get')
            ->with(self::A_KEY)
            ->will(self::returnValue(self::A_VALUE));
        $value = MDC::get(self::A_KEY);
        self::assertEquals(self::A_VALUE, $value);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldGetFailIfKeyIsNull()
    {
        MDC::get(null);
    }

    /**
     * @test
     */
    public function shouldGetContext()
    {
        $this->adapter
            ->expects(self::once())
            ->method('getCopyOfContextMap')
            ->will(self::returnValue($this->aContextMap));
        $result = MDC::getCopyOfContextMap();
        self::assertEquals($this->aContextMap, $result);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldRemoveFailIfKeyIsNull()
    {
        MDC::remove(null);
    }

    /**
     * @test
     */
    public function shouldClear()
    {
        $this->adapter
            ->expects(self::once())
            ->method('clear');
        MDC::clear();
    }

    /**
     * @test
     */
    public function shouldRemove()
    {
        $this->adapter
            ->expects(self::once())
            ->method('remove')
            ->with(self::A_KEY);
        MDC::remove(self::A_KEY);
    }

    /**
     * @test
     */
    public function shouldSetContextMap()
    {
        $this->adapter
            ->expects(self::once())
            ->method('setContextMap')
            ->with($this->aContextMap);
        MDC::setContextMap($this->aContextMap);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldPutCheckAdapter()
    {
        MDCChild::reset();
        self::assertNull(MDC::getMDCAdapter());
        MDC::put(self::A_KEY, self::A_VALUE);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldGetCheckAdapter()
    {
        MDCChild::reset();
        self::assertNull(MDC::getMDCAdapter());
        MDC::get(self::A_KEY);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldClearCheckAdapter()
    {
        MDCChild::reset();
        self::assertNull(MDC::getMDCAdapter());
        MDC::clear();
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldRemoveCheckAdapter()
    {
        MDCChild::reset();
        self::assertNull(MDC::getMDCAdapter());
        MDC::remove(self::A_KEY);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldGetContextCheckAdapter()
    {
        MDCChild::reset();
        self::assertNull(MDC::getMDCAdapter());
        MDC::getCopyOfContextMap();
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldSetContextCheckAdapter()
    {
        MDCChild::reset();
        self::assertNull(MDC::getMDCAdapter());
        MDC::setContextMap($this->aContextMap);
    }
}

class MDCChild extends MDC
{
    public static function setMDCAdapter(MDCAdapter $adapter)
    {
        static::$mdcAdapter = $adapter;
    }

    public static function reset()
    {
        static::$mdcAdapter = null;
    }
}
