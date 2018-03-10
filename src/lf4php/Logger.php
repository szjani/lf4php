<?php
declare(strict_types=1);

namespace lf4php;

use Exception;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
interface Logger
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return boolean
     */
    public function isDebugEnabled() : bool;

    /**
     * @return boolean
     */
    public function isErrorEnabled() : bool;

    /**
     * @return boolean
     */
    public function isInfoEnabled() : bool;

    /**
     * @return boolean
     */
    public function isTraceEnabled() : bool;

    /**
     * @return boolean
     */
    public function isWarnEnabled() : bool;

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $e
     */
    public function debug($format, $params = array(), Exception $e = null);

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $e
     */
    public function error($format, $params = array(), Exception $e = null);

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $e
     */
    public function info($format, $params = array(), Exception $e = null);

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $e
     */
    public function trace($format, $params = array(), Exception $e = null);

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $e
     */
    public function warn($format, $params = array(), Exception $e = null);
}
