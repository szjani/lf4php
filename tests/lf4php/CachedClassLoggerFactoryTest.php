<?php
declare(strict_types=1);

namespace lf4php;

use PHPUnit\Framework\TestCase;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class CachedClassLoggerFactoryTest extends TestCase
{
    /**
     * @var CachedClassLoggerFactory
     */
    private $factory;

    private $defaultLogger;

    public function setUp()
    {
        $this->defaultLogger = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        $this->factory = new CachedClassLoggerFactory($this->defaultLogger);
    }

    public function testGetNotRegisteredLogger()
    {
        self::assertSame($this->defaultLogger, $this->factory->getLogger('notExists'));
    }

    public function testGetRegisteredLogger()
    {
        $logger = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        $this->factory->registerLogger(__NAMESPACE__, $logger);
        self::assertSame($logger, $this->factory->getLogger(__NAMESPACE__));
    }

    public function testGetParentLogger()
    {
        $logger = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        $this->factory->registerLogger(__NAMESPACE__, $logger);
        self::assertSame($logger, $this->factory->getLogger(__CLASS__));
    }

    public function testGetFirstParentLogger()
    {
        $logger1 = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        $logger2 = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        $this->factory->registerLogger('foo', $logger1);
        $this->factory->registerLogger('foo\bar', $logger2);
        self::assertSame($logger2, $this->factory->getLogger('foo\bar\test'));
        self::assertSame($logger1, $this->factory->getLogger('foo\another'));
        self::assertSame($logger1, $this->factory->getLogger('foo\another\something'));
    }

    /**
     * @test
     */
    public function shouldOmitTrailingBackslashes()
    {
        $logger = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        $this->factory->registerLogger('\foo', $logger);
        self::assertSame($logger, $this->factory->getLogger('foo\another'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testLaterRegisteredLogger()
    {
        $fooLogger = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        $this->factory->getLogger('foo\bar');
        $this->factory->registerLogger('foo', $fooLogger);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testLaterSetRootLogger()
    {
        $fooLogger = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        $this->factory->getLogger('foo\bar');
        $this->factory->setRootLogger($fooLogger);
    }

    public function testRootLogger()
    {
        $logger = $this->getMockBuilder(__NAMESPACE__ . '\Logger')->getMock();
        self::assertNotSame($logger, $this->factory->getRootLogger());
        $this->factory->setRootLogger($logger);
        self::assertSame($logger, $this->factory->getRootLogger());
    }
}
