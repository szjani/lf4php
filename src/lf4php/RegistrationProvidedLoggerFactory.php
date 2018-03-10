<?php
declare(strict_types=1);

namespace lf4php;

/**
 * @package lf4php
 *
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
interface RegistrationProvidedLoggerFactory extends ILoggerFactory
{
    /**
     * @param Logger $logger
     */
    public function setRootLogger(Logger $logger) : void;

    /**
     * @return Logger
     */
    public function getRootLogger() : Logger;

    /**
     * @param string $classOrNamespace
     * @param Logger $logger
     */
    public function registerLogger(string $classOrNamespace, Logger $logger) : void;
}
