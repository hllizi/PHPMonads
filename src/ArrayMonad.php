<?php
namespace Hllizi\PHPMonads;

class ArrayMonad extends \ArrayObject
{
    use MonadTrait;

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

    public function return($x)
    {
        return new ArrayMonad([$x]);
    }

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
