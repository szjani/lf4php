<?php
declare(strict_types=1);

namespace lf4php;

use lf4php\helpers\BasicMDCAdapter;
use lf4php\spi\MDCAdapter;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class MDCTest
 *
 * @package lf4php
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class MDCTest extends TestCase
{
    const A_KEY = 'key1';
    const A_VALUE = 'value1';

    /**
     * @var MockObject
     */
    private $adapter;
    private $aContextMap;

    protected function setUp()
    {
        $this->adapter = $this->getMockBuilder(MDCAdapter::class)->getMock();
        $this->aContextMap = array(self::A_KEY, self::A_VALUE);
        MDCChild::setMDCAdapter($this->adapter);
    }

    /**
     * @test
     */
    public function shouldReturnBasicMDCAdapter()
    {
        MDCChild::reset();
        MDC::init();
        self::assertInstanceOf(BasicMDCAdapter::class, MDC::getMDCAdapter());
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
