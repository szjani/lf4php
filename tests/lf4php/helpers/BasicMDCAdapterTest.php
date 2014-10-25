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

namespace lf4php\helpers;

use PHPUnit_Framework_TestCase;

class BasicMDCAdapterTest extends PHPUnit_Framework_TestCase
{
    const A_KEY = 'key1';
    const A_KEY2 = 'key2';
    const A_VALUE = 'value1';
    const A_VALUE2 = 'value2';

    private $aContextMap;

    /**
     * @var BasicMDCAdapter
     */
    private $adapter;

    protected function setUp()
    {
        $this->adapter = new BasicMDCAdapter();
        $this->aContextMap = array(self::A_KEY, self::A_VALUE);
    }

    /**
     * @test
     */
    public function shouldGetReturnNullIfKeyDoesNotExist()
    {
        self::assertNull($this->adapter->get('invalid'));
    }

    /**
     * @test
     */
    public function shouldGetProperlyWork()
    {
        $this->adapter->put(self::A_KEY, self::A_VALUE);
        self::assertEquals(self::A_VALUE, $this->adapter->get(self::A_KEY));
    }

    /**
     * @test
     */
    public function shouldRemoveKey()
    {
        $this->adapter->put(self::A_KEY, self::A_VALUE);
        $this->adapter->remove(self::A_KEY);
        self::assertNull($this->adapter->get(self::A_KEY));
    }

    /**
     * @test
     */
    public function shouldDoNothingRemovingInvalidKey()
    {
        $invalidKey = 'invalid';
        $this->adapter->remove($invalidKey);
        self::assertNull($this->adapter->get($invalidKey));
    }

    /**
     * @test
     */
    public function shouldClearEveryThing()
    {
        $this->adapter->put(self::A_KEY, self::A_VALUE);
        $this->adapter->put(self::A_KEY2, self::A_VALUE2);
        $this->adapter->clear();
        self::assertNull($this->adapter->get(self::A_KEY));
        self::assertNull($this->adapter->get(self::A_KEY2));
    }

    /**
     * @test
     */
    public function shouldGetContext()
    {
        $this->adapter->put(self::A_KEY, self::A_VALUE);
        $this->adapter->put(self::A_KEY2, self::A_VALUE2);
        $result = $this->adapter->getCopyOfContextMap();
        self::assertEquals(self::A_VALUE, $result[self::A_KEY]);
        self::assertEquals(self::A_VALUE2, $result[self::A_KEY2]);
    }

    /**
     * @test
     */
    public function shouldOverwriteContextMap()
    {
        $this->adapter->put(self::A_KEY2, self::A_VALUE2);
        $this->adapter->setContextMap($this->aContextMap);
        self::assertEquals($this->aContextMap, $this->adapter->getCopyOfContextMap());
    }
}
