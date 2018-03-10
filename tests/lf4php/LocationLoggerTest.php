<?php
declare(strict_types=1);

namespace lf4php;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class LocationLoggerTest extends TestCase
{
    private $logger;

    public function setUp()
    {
        $this->logger = new LocationLoggerMock();
    }

    public function testGetLocation()
    {
        self::assertEquals(__CLASS__, $this->logger->debug('test'));
    }

    public function testGetShortLocation()
    {
        self::assertEquals('l\LocationLoggerTest', $this->logger->info('test'));
    }
}

class LocationLoggerMock extends LocationLogger
{
    public function debug($format, $params = array(), Exception $e = null)
    {
        return $this->getLocation();
    }

    public function error($format, $params = array(), Exception $e = null)
    {

    }

    public function getName() : string
    {

    }

    public function info($format, $params = array(), Exception $e = null)
    {
        return $this->getShortLocation();
    }

    public function isDebugEnabled() : bool
    {

    }

    public function isErrorEnabled() : bool
    {

    }

    public function isInfoEnabled() : bool
    {

    }

    public function isTraceEnabled() : bool
    {

    }

    public function isWarnEnabled() : bool
    {

    }

    public function trace($format, $params = array(), Exception $e = null)
    {

    }

    public function warn($format, $params = array(), Exception $e = null)
    {

    }
}
