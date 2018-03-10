<?php
declare(strict_types=1);

namespace lf4php;

use RuntimeException;

/**
 * @package lf4php
 *
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
final class InitializedFactory extends RegistrationProvidedLoggerFactoryProxy
{
    /**
     * @param string $classOrNamespace
     * @param Logger $logger
     * @throws \RuntimeException
     */
    public function registerLogger(string $classOrNamespace, Logger $logger) : void
    {
        $this->throwException();
    }

    /**
     * @param Logger $logger
     * @throws \RuntimeException
     */
    public function setRootLogger(Logger $logger) : void
    {
        $this->throwException();
    }

    private function throwException() : void
    {
        throw new RuntimeException(
            "Cannot register any Logger instances after the first call of getLogger() method"
        );
    }
}
