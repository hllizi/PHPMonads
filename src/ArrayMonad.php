<?php
namespace Hllizi\PHPMonads;

/**
 * ArrayMonad 
 * 
 * @package phpmonads
 * @copyright David Lahm 
 * @author David Lahm 
 * @license GPL-2 
 *
 * The class extends ArrayObject with the monad trait, providing appropriate implementations for bind() and return(), and adds additional convenient methods.
 */
class ArrayMonad extends \ArrayObject
	implements MonadInterface

{
    use MonadTrait;

    /**
     * __construct 
     * 
     * @param array $data 
     * @param bool $recursive 
     * @access public
     * @return void
     *
     * If $recursive is true, any element of $data that is an array itself will also be turned into an ArrayMonad.
     */
    public function __construct(array $data = [], bool $recursive = false)
    {
        $converted = [];
        if($recursive) {
            foreach($data as $datum) {
                $converted[] = is_array($datum) ? new self($datum, true) : $datum;
            }
        } else {
            $converted = $data;
        }
        parent::__construct($converted);
    }


    /**
     * @param callable $function
     * @return ArrayMonad
     *
     * Bind applies its argument to each element of the array and concatenates the results.
     */
    public function bind(callable $function)
    {
        $result = new ArrayMonad();
        foreach($this as $element) {
            $function_result=call_user_func($function, $element);
            foreach($function_result as $token) {
                $result->append($token);
            }
        }
        return $result;
    }


    /**
     * @param $x
     * @return ArrayMonad
     */
    public function return($x)
    {
        return new ArrayMonad([$x]);
    }

    /**
     * getArrayCopy 
     * 
     * @param mixed $recursive 
     * @access public
     * @return array
     *
     * Adds to the parent method the $recursive flag: if recursive is set, any object of class self will also be turned into an array.
     */
    public function getArrayCopy($recursive = false)
    {
        if($recursive) {
            $array = [];
            foreach ($this as $element) {
                $array[] = $element instanceof self ? $element->toArray() : $element;
            }
        } else {
            $array = parent::getArrayCopy();
        }
        return $array;
    }
}
