<?php
/*
 * Copyright (c) 2012 Janos Szurovecz
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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
    protected function getLocation($backtraceLevel = self::DEFAULT_BACKTRACE_LEVEL)
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

    protected function getShortLocation($backtraceLevel = self::DEFAULT_BACKTRACE_LEVEL)
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

    public function getLocationPrefix()
    {
        return $this->locationPrefix;
    }

    public function setLocationPrefix($prefix)
    {
        $this->locationPrefix = (string) $prefix;
    }

    public function getLocationSuffix()
    {
        return $this->locationSuffix;
    }

    public function setLocationSuffix($suffix)
    {
        $this->locationSuffix = (string) $suffix;
    }
}
