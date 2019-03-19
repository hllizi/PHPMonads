<?php
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 19.03.19
 * Time: 15:53
 */

namespace Hllizi\PHPMonads;


use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    public function testFold()
    {
        $testObject = new ArrayMonad([1,2,3]);
        $this->assertEquals(6, $testObject->fold(0, function ($i, $j) {return $i+$j;}));
        $this->assertEquals(6, $testObject->fold(1, function ($i, $j) {return $i*$j;}));
    }
}