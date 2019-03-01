<?php

/* Author: David Lahm
 * Date: Feb. 28 2019
 * */

namespace Hllizi\PHPMonads;

interface MonadInterface
{
	public function bind(callable $function);
	public function return($x);
}
