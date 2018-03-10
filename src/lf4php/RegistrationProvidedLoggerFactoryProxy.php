<?php
declare(strict_types=1);

namespace lf4php;

/**
 * @package lf4php
 *
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class RegistrationProvidedLoggerFactoryProxy implements RegistrationProvidedLoggerFactory
{
    /**
     * @var RegistrationProvidedLoggerFactory
     */
    protected $factory;

    public function __construct(RegistrationProvidedLoggerFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return Logger
     */
    public function getRootLogger() : Logger
    {
        return $this->factory->getRootLogger();
    }

    /**
     * @param Logger $logger
     */
    public function setRootLogger(Logger $logger) : void
    {
        $this->factory->setRootLogger($logger);
    }

    /**
     * @param string $classOrNamespace
     * @param Logger $logger
     */
    public function registerLogger(string $classOrNamespace, Logger $logger) : void
    {
        $this->factory->registerLogger($classOrNamespace, $logger);
    }

    /**
     * @param string $name
     * @return Logger
     */
    public function getLogger(string $name) : Logger
    {
        return $this->factory->getLogger($name);
    }
}
