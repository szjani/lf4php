<?php
declare(strict_types=1);

namespace lf4php;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
interface ILoggerFactory
{
    /**
     * @param string $name
     * @return Logger
     */
    public function getLogger(string $name) : Logger;
}
