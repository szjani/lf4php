<?php
/*
 * Copyright (c) 2014 Janos Szurovecz
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

use LazyMap\AbstractLazyMap;

class LoggerMap extends AbstractLazyMap implements RegistrationProvidedLoggerFactory
{
    const SEPARATOR = '\\';

    /**
     * @var Logger
     */
    private $rootLogger;

    public function __construct(Logger $rootLogger)
    {
        $this->rootLogger = $rootLogger;
    }

    /**
     * @return Logger
     */
    public function getRootLogger()
    {
        return $this->rootLogger;
    }

    /**
     * @param Logger $rootLogger
     */
    public function setRootLogger(Logger $rootLogger)
    {
        $this->rootLogger = $rootLogger;
    }

    /**
     * @param string $name
     * @return Logger
     */
    public function getLogger($name)
    {
        $key = (string) $name;
        return $this->$key;
    }

    /**
     * @param string $classOrNamespace
     * @param Logger $logger
     */
    public function registerLogger($classOrNamespace, Logger $logger)
    {
        $key = $this->trim((string) $classOrNamespace);
        $this->$key = $logger;
    }

    /**
     * Instantiate a particular key by the given name
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function instantiate($name)
    {
        $parts = explode(self::SEPARATOR, $this->trim($name));
        array_pop($parts);
        if (empty($parts)) {
            return $this->rootLogger;
        } else {
            $parentName = implode(self::SEPARATOR, $parts);
            return $this->$parentName;
        }
    }

    private function trim($name)
    {
        return trim($name, self::SEPARATOR);
    }
}
