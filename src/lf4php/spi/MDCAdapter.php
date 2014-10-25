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

namespace lf4php\spi;

/**
 * This interface abstracts the service offered by various MDC
 * implementations.
 *
 * @package lf4php\spi
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
interface MDCAdapter
{
    /**
     * @param string $key
     * @param string $value
     */
    public function put($key, $value);

    /**
     * @param string $key
     * @return string
     */
    public function get($key);

    /**
     * @param string $key
     */
    public function remove($key);

    public function clear();

    /**
     * @return array|null
     */
    public function getCopyOfContextMap();

    /**
     * @param array $contextMap
     */
    public function setContextMap(array $contextMap);
}
