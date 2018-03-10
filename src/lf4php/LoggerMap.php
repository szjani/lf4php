<?php
declare(strict_types=1);

namespace lf4php;

use LazyMap\AbstractLazyMap;

class LoggerMap extends AbstractLazyMap implements RegistrationProvidedLoggerFactory
{
    const SEPARATOR = '\\';

    /**
     * @var Logger
     */
    private $rootLogger;

    public function __construct(Logger $rootLogger)
    {
        $this->rootLogger = $rootLogger;
    }

    /**
     * @return Logger
     */
    public function getRootLogger() : Logger
    {
        return $this->rootLogger;
    }

    /**
     * @param Logger $rootLogger
     */
    public function setRootLogger(Logger $rootLogger) : void
    {
        $this->rootLogger = $rootLogger;
    }

    /**
     * @param string $name
     * @return Logger
     */
    public function getLogger(string $name) : Logger
    {
        $key = (string) $name;
        return $this->$key;
    }

    /**
     * @param string $classOrNamespace
     * @param Logger $logger
     */
    public function registerLogger(string $classOrNamespace, Logger $logger) : void
    {
        $key = $this->trim((string) $classOrNamespace);
        $this->$key = $logger;
    }

    /**
     * Instantiate a particular key by the given name
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function instantiate($name)
    {
        $parts = explode(self::SEPARATOR, $this->trim($name));
        array_pop($parts);
        if (empty($parts)) {
            return $this->rootLogger;
        } else {
            $parentName = implode(self::SEPARATOR, $parts);
            return $this->$parentName;
        }
    }

    private function trim(string $name) : string
    {
        return trim($name, self::SEPARATOR);
    }
}
