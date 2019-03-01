<?php
namespace Hllizi\PHPMonads;

class MaybeMonad
{
    use MonadTrait;

    private $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function bind(callable $method)
    {
        if($this->isSomething()) {
            return call_user_func($method, $this->value);
        } else {
            return new MaybeMonad(null);
        }
    }

    public function return($x)
    {
        if(isset($x)) {
            return new MaybeMonad($x);
        } else {
            throw new IllicitValueException("MaybeMonad::return() cannot be used with null argument (use constructor instead).");
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isSomething()
    {
        return isset($this->value);
    }

    public function isNothing()
    {
        return !isSomething();
    }

    public function toArrayMonad()
    {
        return new ArrayMonad($this->isSomething() ? [$this->value] : []);
    }
}
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 27.02.19
 * Time: 13:42
 */
