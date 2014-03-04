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

namespace lf4php\helpers;

use Exception;
use PHPUnit_Framework_TestCase;
use precore\util\error\ErrorHandler;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class MessageFormatterTest extends PHPUnit_Framework_TestCase
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
        ErrorHandler::register();
        $obj = new \stdClass();
        $output = MessageFormatter::format('Object id: {}', array($obj));
        self::assertStringEndsWith(spl_object_hash($obj), $output);
        restore_error_handler();
    }
}
