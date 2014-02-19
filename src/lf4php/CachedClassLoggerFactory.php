<?php
/*
 * Copyright (c) 2012 Szurovecz János
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

use RuntimeException;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class CachedClassLoggerFactory implements ILoggerFactory
{
    /**
     * @var LoggerMap
     */
    private $map;
    private $alreadyUsed = false;

    /**
     * @param Logger $rootLogger
     */
    public function __construct(Logger $rootLogger)
    {
        $this->map = new LoggerMap($rootLogger);
    }

    /**
     * @param Logger $logger
     */
    final public function setRootLogger(Logger $logger)
    {
        $this->checkNotUsed();
        $this->map->setRootLogger($logger);
    }

    /**
     * @return Logger
     */
    final public function getRootLogger()
    {
        return $this->map->getRootLogger();
    }

    /**
     * @param string $classOrNamespace
     * @param Logger $logger
     */
    public function registerLogger($classOrNamespace, Logger $logger)
    {
        $this->checkNotUsed();
        $key = (string) $classOrNamespace;
        $this->map->$key = $logger;
    }

    /**
     * @param string $name
     * @return Logger
     */
    public function getLogger($name)
    {
        $this->alreadyUsed = true;
        $key = (string) $name;
        return $this->map->$key;
    }

    protected function checkNotUsed()
    {
        if ($this->alreadyUsed) {
            throw new RuntimeException(
                "Cannot register any Logger instances after the first call of getLogger() method"
            );
        }
    }
}
