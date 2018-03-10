<?php
declare(strict_types=1);

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

    public function put(string $key, string $value) : void
    {
        $this->contextMap[$key] = $value;
    }

    public function get(string $key) : ?string
    {
        return array_key_exists($key, $this->contextMap)
            ? $this->contextMap[$key]
            : null;
    }

    public function remove(string $key) : void
    {
        unset($this->contextMap[$key]);
    }

    public function clear() : void
    {
        $this->contextMap = array();
    }

    /**
     * @return array|null
     */
    public function getCopyOfContextMap() : ?array
    {
        return $this->contextMap;
    }

    public function setContextMap(array $contextMap) : void
    {
        $this->contextMap = $contextMap;
    }
}
