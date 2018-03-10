<?php
declare(strict_types=1);

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
    public function put(string $key, string $value) : void;

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key) : ?string;

    /**
     * @param string $key
     */
    public function remove(string $key) : void;

    public function clear() : void;

    /**
     * @return array|null
     */
    public function getCopyOfContextMap() : ?array;

    /**
     * @param array $contextMap
     */
    public function setContextMap(array $contextMap) : void;
}
