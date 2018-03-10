<?php
declare(strict_types=1);

namespace lf4php\nop;

use Exception;
use lf4php\helpers\NamedLoggerBase;

/**
 * @SuppressWarnings("unused")
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class NOPLogger extends NamedLoggerBase
{
    const NAME = 'NOP';

    private static $instance = null;

    /**
     * @return NOPLogger
     */
    public static function getNOPLogger() : NOPLogger
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct()
    {
        $this->name = self::NAME;
    }

    public function debug($format, $params = array(), Exception $e = null)
    {
    }

    public function error($format, $params = array(), Exception $e = null)
    {
    }

    public function info($format, $params = array(), Exception $e = null)
    {
    }

    public function trace($format, $params = array(), Exception $e = null)
    {
    }

    public function warn($format, $params = array(), Exception $e = null)
    {
    }

    public function isDebugEnabled() : bool
    {
        return false;
    }

    public function isErrorEnabled() : bool
    {
        return false;
    }

    public function isInfoEnabled() : bool
    {
        return false;
    }

    public function isTraceEnabled() : bool
    {
        return false;
    }

    public function isWarnEnabled() : bool
    {
        return false;
    }
}
