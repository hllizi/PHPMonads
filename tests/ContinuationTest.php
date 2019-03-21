<?php
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 21.03.19
 * Time: 09:18
 */

namespace Hllizi\PHPMonads;


use PHPUnit\Framework\TestCase;

class ContinuationTest extends TestCase
{
    public function testEmpty()
    {
        $this->assertTrue(true);
    }

    public function testSimpleCase()
    {
        $cm = (new ContinuationMonad())->return(2);
        $result = $cm->runCont(function ($n) {
            return $n * 3;
        });
        $this->assertEquals(6, $result);
    }

    public function testSimpleBind()
    {
        $cm = (new ContinuationMonad())->return(2);
        $cm2 = $cm->bind(function ($n) {
            return function ($k) use ($n) {
                return call_user_func($k, $n + 5);
            };
        });
        $result = $cm2->runCont(
            function ($n) {
                return $n * 3;
            });
        $this->assertEquals(21, $result);
    }
}