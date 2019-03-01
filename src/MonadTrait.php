<?php
/**
 * Created by PhpStorm.
 * User: David Lahm
 * Date: 27.02.19
 * Time: 10:58
 */

namespace Hllizi\PHPMonads;

trait MonadTrait
{
    public abstract function bind(callable $function);
    public abstract function return($x);

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

    public function map(callable $function)
    {
        $lifted = function ($argument) use ($function) {
            return $this->return(call_user_func($function, $argument));
        };
        return $this->bind($lifted);

    }

}
