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
 * Implementation of the Maybe monad. Implements the MonadInterface uses the MonadTrait, implementing its abstract methods. Additionally, the method getValue() is provided in order to extract computation results and the method toArrayObject() to turn objects into corresponding ArrayObjects. The prototype of the ArrayObject can be set with setArrayObjectPrototype().
 */
class MaybeMonad
    implements MonadInterface
{
    use MonadTrait;

    private $value;
    private $arrayObjectPrototype;

    public function __construct($value = null)
    {
        $this->value = $value;
    }


    /**
     * @param callable $method
     * @return MaybeMonad
     *
     * Apply the argument to the value if the value is not null. Return $this otherwise.
     */
    public function bind(callable $method)
    {
        if ($this->isSomething()) {
            $newMaybeMonad = call_user_func($method, $this->value);
            return $newMaybeMonad->setArrayObjectPrototype($this->arrayObjectPrototype);
        } else {
            return $this;
        }
    }


    /**
     * @param $x
     * @return MaybeMonad
     * @throws IllicitValueException
     *
     * Construct a new object using the argument if the argument is not null. Throw an exception otherwise. (Since a MaybeMonad object with a null value is interpreted as Nothing and return should not return nothing.)
     */
    public function return($x)
    {
        if (isset($x)) {
            return (new MaybeMonad($x))->setArrayObjectPrototype($this->arrayObjectPrototype);
        } else {
            throw new IllicitValueException("MaybeMonad::return() cannot be used with null argument (use constructor instead).");
        }
    }

    /**
     * @return |null
     *
     * Extract the value. (Regardless of whtether null or not.
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @return bool
     *
     * True if the object has a defined (non-null) value.
     */
    public function isSomething()
    {
        return isset($this->value);
    }


    /**
     * @return bool
     *
     * True if the object has a null value.
     */
    public function isNothing()
    {
        return !$this->isSomething();
    }


    /**
     * toArrayMonad
     *
     * @access public
     * @return ArrayMonad
     *
     * Turn the object into a singleton ArrayObject, according to the prototype provided. With no prototype given, an ArrayMonad will be created.
     */

    public function toArrayObject()
    {
        $arrayObject = isset($this->arrayObjectPrototype) ? (clone $this->arrayObjectPrototype) : new ArrayMonad();
        $arrayObject->exchangeArray($this->isSomething() ? [$this->value] : []);
        return $arrayObject;
    }

    public function setArrayObjectPrototype($arrayObjectPrototype)
    {
        $this->arrayObjectPrototype = $arrayObjectPrototype;
        return $this;
    }
}
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 27.02.19
 * Time: 13:42
 */
