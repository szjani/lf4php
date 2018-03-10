<?php
declare(strict_types=1);

namespace lf4php;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class CachedClassLoggerFactory extends RegistrationProvidedLoggerFactoryProxy
{
    /**
     * @param Logger $rootLogger
     */
    public function __construct(Logger $rootLogger)
    {
        parent::__construct(new NotInitializedFactory(new LoggerMap($rootLogger), $this));
    }
}
