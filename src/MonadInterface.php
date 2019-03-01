<?php

/* Author: David Lahm
 * Date: Feb. 28 2019
 * */

namespace Hllizi\PHPMonads;

/**
 * MonadInterface 
 * 
 * @package phpmonads
 * @version $id$
 * @copyright 2019 David Lahm
 * @author David Lahm 
 * @license GPL-2
 *
 * The interface demands the presence of the functions bind and return. While further restrictions on the types would be in order, these cannot be expressed an need to be enforced manually.
 */

interface MonadInterface
{
	public function bind(callable $function);
	public function return($x);
}
