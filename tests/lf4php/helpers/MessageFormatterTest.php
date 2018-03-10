<?php
declare(strict_types=1);

namespace lf4php\helpers;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
class MessageFormatterTest extends TestCase
{
    public function testFormat()
    {
        $result = MessageFormatter::format("Hello {}, are you {}?", array('John', 'ok'));
        self::assertEquals('Hello John, are you ok?', $result);
    }

    public function testException()
    {
        $result = MessageFormatter::format(new Exception('Test exception'));
        self::assertTrue(strpos($result, __CLASS__) !== false);
    }

    public function testNested()
    {
        $result = MessageFormatter::format("Set {1,2} differs from {{}}", array(3));
        self::assertEquals('Set {1,2} differs from {3}', $result);
    }

    public function testStringCastError()
    {
        set_error_handler(
            function () {
                if (error_reporting() == 0) {
                    return false;
                }
                throw new Exception();
            }
        );
        $obj = new \stdClass();
        $output = MessageFormatter::format('Object id: {}', array($obj));
        self::assertStringEndsWith(spl_object_hash($obj), $output);
        restore_error_handler();
    }
}
