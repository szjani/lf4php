<?php
declare(strict_types=1);

namespace lf4php;

/**
 * @package lf4php
 *
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
final class NotInitializedFactory extends RegistrationProvidedLoggerFactoryProxy
{
    /**
     * @var RegistrationProvidedLoggerFactoryProxy
     */
    private $parentProxy;

    public function __construct(
        RegistrationProvidedLoggerFactory $factory,
        RegistrationProvidedLoggerFactoryProxy $parentProxy
    ) {
        parent::__construct($factory);
        $this->parentProxy = $parentProxy;
    }

    /**
     * @param string $name
     * @return Logger
     */
    public function getLogger(string $name) : Logger
    {
        $this->parentProxy->factory = new InitializedFactory($this->factory);
        return $this->factory->getLogger($name);
    }
}
