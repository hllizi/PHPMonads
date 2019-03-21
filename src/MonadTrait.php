<?php
namespace Hllizi\PHPMonads;

/**
 *  
 *  The trait demands that the abstract methods bind and return be implemented and thickens the interface by providing implementing map and join based on these two.
 */
trait MonadTrait
{
    /**
     * @param callable $function
     * @return mixed
     */
    public abstract function bind(callable $function);

    /**
     * @param $x
     * @return mixed
     */
    public abstract function return($x);

    /**
     * @return mixed
     */

    public function join()
    {
        $id = function ($x) {
            if (!$x instanceof self) {
                throw new
                IncompatibleTypeException("Monad::join(): Embedded objects must belong to the same Monad");
            } else {
                return $x;
            }
        };

        return $this->bind($id);
    }

    /**
     * @param callable $function
     * @return mixed
     */
    public function map(callable $function)
    {
        $lifted = function ($argument) use ($function) {
            return $this->return(call_user_func($function, $argument));
        };
        return $this->bind($lifted);

    }
}
