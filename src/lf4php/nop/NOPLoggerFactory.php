<?php
declare(strict_types=1);

namespace lf4php\nop;

use lf4php\ILoggerFactory;
use lf4php\Logger;

/**
 * @SuppressWarnings("unused")
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class NOPLoggerFactory implements ILoggerFactory
{
    private $logger;

    public function __construct()
    {
        $this->logger = NOPLogger::getNOPLogger();
    }

    /**
     * @param string $name
     * @return Logger
     */
    public function getLogger(string $name) : Logger
    {
        return $this->logger;
    }
}
