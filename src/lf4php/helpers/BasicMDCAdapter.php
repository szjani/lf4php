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

namespace lf4php\helpers;

use lf4php\spi\MDCAdapter;

/**
 * Basic MDC implementation, which can be used with logging systems that lack
 * out-of-the-box MDC support.
 *
 * @package lf4php\helpers
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class BasicMDCAdapter implements MDCAdapter
{
    private $contextMap = array();

    public function put($key, $value)
    {
        $this->contextMap[$key] = $value;
    }

    public function get($key)
    {
        return array_key_exists($key, $this->contextMap)
            ? $this->contextMap[$key]
            : null;
    }

    public function remove($key)
    {
        unset($this->contextMap[$key]);
    }

    public function clear()
    {
        $this->contextMap = array();
    }

    /**
     * @return array|null
     */
    public function getCopyOfContextMap()
    {
        return $this->contextMap;
    }

    public function setContextMap(array $contextMap)
    {
        $this->contextMap = $contextMap;
    }
}
