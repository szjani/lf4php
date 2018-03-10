<?php
declare(strict_types=1);

namespace lf4php\helpers;

use lf4php\Logger;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
abstract class NamedLoggerBase implements Logger
{
    protected $name;

    public function getName() : string
    {
        return $this->name;
    }
}
