<?php

namespace Hllizi\PHPMonads;

/**
 * MaybeMonad 
 * 
 * @package phpmonads
 * @version $id$
 * @copyright 2019 David Lahm
 * @author David Lahm 
 * @license GPL-2
 *
 * Implementation of the Maybe monad. Implements the MonadInterface uses the MonadTrait, implementing its abstract methods. Additionally, the method getValue() is provided in order to extract computation results.
 */

class MaybeMonad
	implements MonadInterface
{
    use MonadTrait;

    private $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * bind 
     * 
     * @param callable $method 
     * @access public
     * @return void
     *
     * Apply the argument to the value if the value is not null. Return $this otherwise.
     */
    public function bind(callable $method)
    {
        if($this->isSomething()) {
            return call_user_func($method, $this->value);
        } else {
            return $this;
        }
    }

    /**
     * return 
     * 
     * @param mixed $x 
     * @access public
     * @return void
     *
     * Construct a new object using the argument if the argument is not null. Throw an exception otherwise. (Since a MaybeMonad object with a null value is interpreted as Nothing and return should not return nothing.) 
     */
    public function return($x)
    {
        if(isset($x)) {
            return new MaybeMonad($x);
        } else {
            throw new IllicitValueException("MaybeMonad::return() cannot be used with null argument (use constructor instead).");
        }
    }

    /**
     * getValue 
     * 
     * @access public
     * @return void
     *
     * Extract the value. (Regardless of whtether null or not.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * isSomething 
     * 
     * @access public
     * @return void
     *
     * True if the object has a defined (non-null) value.
     */

    public function isSomething()
    {
        return isset($this->value);
    }

    /**
     * isNothing 
     * 
     * @access public
     * @return void
     *
     * True if the object has a null value.
     */
    public function isNothing()
    {
        return !isSomething();
    }

    
    /**
     * toArrayMonad 
     * 
     * @access public
     * @return void
     *
     * Turn the object into a singleton ArrayMonad. (Dependencies here should be inverted).
     */
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
