<?php
declare(strict_types=1);

namespace lf4php\helpers;

use lf4php\LoggerFactory;
use lf4php\nop\NOPLogger;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class LoggingTest extends TestCase
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
