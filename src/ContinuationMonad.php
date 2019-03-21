<?php
namespace Hllizi\PHPMonads;
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 20.03.19
 * Time: 16:16
 */

class ContinuationMonad
{
    use MonadTrait;
    private $consumer;

    public function __construct(callable $consumer = null)
    {
        $this->consumer = $consumer;
    }

    public function bind(callable $function)
    {
        $consumer = $this->consumer;
        $newConsumer = function ($k) use ($function, $consumer) {
            return
                call_user_func(
                    $consumer,
                    function ($x) use ($function, $k) {
                        return
                            call_user_func(
                                call_user_func(
                                    $function,
                                    $x),
                                $k);
                    });
        };
        return new ContinuationMonad($newConsumer);
    }

    public function return($x)
    {
        return new ContinuationMonad(function ($k) use ($x) {return call_user_func($k, $x);});
    }

    public function runCont($cont)
    {
        return call_user_func($this->consumer, $cont);
    }
}