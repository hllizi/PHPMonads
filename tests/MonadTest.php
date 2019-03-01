<?php

/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 28.02.19
 * Time: 13:25
 */

namespace Hllizi\PHPMonads;

use \ReflectionClass;
use \Hllizi\PHPMonads;

class MonadTest extends \PHPUnit\Framework\TestCase

{
    private $testMonads = ["\Hllizi\PHPMonads\MaybeMonad", "\Hllizi\PHPMonads\ArrayMonad"];
    private $numbers = [1, 2, 3, 4, 5];
    private $function;

    //Test of the law return a >>= f = f a
    public function testMonadLaw1()
    {
        foreach ($this->testMonads as $monad) {
            $starter = new $monad();
            foreach ($this->numbers as $number) {
                $this->function = function ($x) {
                    return $x + 1;
                };

                $m = $starter->return($number);
                $result = $m
                    ->bind(function ($x) use ($starter) {
                        return $starter->return(call_user_func($this->function, $x));
                    });
                $this->assertEquals($starter->return(call_user_func($this->function, $number)), $result);
            }
        }
    }

    //Test of the law m >>= return = m
    public function testMonadLaw2()
    {
        $things = [1, 'a', "Boofo", false, 1.294, new MaybeMonad("Boofo", null)];
        foreach ($this->testMonads as $monad) {
        $starter = new $monad();

            foreach ($things as $thing) {
                $m = $starter->return($thing);
                $m2 = $m
                    ->bind(function ($o) use ($m) {
                        return $m->return($o);
                    });

                $this->assertEquals($m, $m2);
            }
        }

    }

    //Test of the law m >>= f >>= g = m >>= (\x -> f x >>= g)
    public function testMonadLaw3()
    {
        foreach ($this->testMonads as $monad) {
            $starter = new $monad();

            $f = function ($x) use ($monad,$starter) {
                return $starter->return($x + 1);
            };

            $g = function ($x) use ($monad,$starter) {
                return $starter->return($x * 3);
            };

            foreach ($this->numbers as $thing) {
                $m = $starter->return($thing);
                $m2 = $m->bind($f);
                $m3 = $m2->bind($g);

                $new = function ($x) use ($f, $g) {
                    return call_user_func($f, $x)
                        ->bind($g);
                };
                $m4 = $m->bind($new);
                $this->assertEquals($m3, $m4);
            }
        }
    }

    public function testArrayMonadJoin()
    {
        $am = new ArrayMonad([[1,2],[3,4]],true);
        $this->assertEquals([1,2,3,4], $am->join()->getArrayCopy());
    }

    public function testArrayMonadMap()
    {
        $am = new ArrayMonad($this->numbers);
        $this->assertEquals([2,4,6,8,10], $am->map(function ($i) {return $i*2;})->getArrayCopy());
    }
}
