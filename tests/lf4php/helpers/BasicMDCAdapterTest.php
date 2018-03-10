<?php
declare(strict_types=1);

namespace lf4php\helpers;

use PHPUnit\Framework\TestCase;

class BasicMDCAdapterTest extends TestCase
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
