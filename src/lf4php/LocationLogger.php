<?php
declare(strict_types=1);

namespace lf4php;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
abstract class LocationLogger implements Logger
{
    const DEFAULT_BACKTRACE_LEVEL = 2;

    const DEFAULT_LOCATION_PREFIX = ' - ';

    const DEFAULT_LOCATION_SUFFIX = ' - ';

    private $locationPrefix = self::DEFAULT_LOCATION_PREFIX;

    private $locationSuffix = self::DEFAULT_LOCATION_SUFFIX;

    /**
     * Get caller class name.
     *
     * @param int $backtraceLevel
     */
    protected function getLocation(int $backtraceLevel = self::DEFAULT_BACKTRACE_LEVEL) : string
    {
        $trace = null;
        if (version_compare(PHP_VERSION, '5.3.6', '<')) {
            $trace = debug_backtrace(false);
        } elseif (version_compare(PHP_VERSION, '5.4', '<')) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        } else {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $backtraceLevel + 1);
        }

        $traceCount = count($trace);
        if ($backtraceLevel <= $traceCount) {
            return !empty($trace[$backtraceLevel]['class'])
                ? $trace[$backtraceLevel]['class']
                : $trace[$backtraceLevel - 1]['file'];
        } else {
            return $trace[$traceCount - 1]['file'];
        }
    }

    protected function getShortLocation(int $backtraceLevel = self::DEFAULT_BACKTRACE_LEVEL) : string
    {
        $parts = explode('\\', $this->getLocation($backtraceLevel + 1));
        $count = count($parts);
        $res = array();
        for ($i = 0; $i < $count - 1; $i++) {
            $res[] = substr($parts[$i], 0, 1);
        }
        $res[] = $parts[$i];
        return implode('\\', $res);
    }

    public function getLocationPrefix() : string
    {
        return $this->locationPrefix;
    }

    public function setLocationPrefix(string $prefix) : void
    {
        $this->locationPrefix = $prefix;
    }

    public function getLocationSuffix() : string
    {
        return $this->locationSuffix;
    }

    public function setLocationSuffix(string $suffix) : void
    {
        $this->locationSuffix = $suffix;
    }
}
