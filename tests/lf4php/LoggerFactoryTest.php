<?php
declare(strict_types=1);

namespace lf4php;

use lf4php\nop\NOPLoggerFactory;
use PHPUnit\Framework\TestCase;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class LoggerFactoryTest extends TestCase
{
    public function testFindKnownBindingsMissing()
    {
        $factory = LoggerFactory::getILoggerFactory();
        self::assertInstanceOf(NOPLoggerFactory::class, $factory);
    }

    /**
     * @test
     */
    public function shouldUseFoundILoggerFactory()
    {
        $factory = $this->getMockBuilder(ILoggerFactory::class)->getMock();
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