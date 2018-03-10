<?php
declare(strict_types=1);

namespace lf4php\helpers;

use Exception;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class MessageFormatter
{
    private function __construct()
    {
    }

    public static function format($message, $args = array()) : string
    {
        return preg_replace_callback(
            '#{}#',
            function () use (&$args) {
                $arg = array_shift($args);
                try {
                    return (string) $arg;
                } catch (Exception $e) {
                    return spl_object_hash($arg);
                }
            },
            $message
        );
    }
}
