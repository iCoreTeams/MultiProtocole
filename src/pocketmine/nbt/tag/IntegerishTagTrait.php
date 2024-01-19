<?php

/*
 *
 *                            __  __ _
 *     /\                    |  \/  (_)
 *    /  \   __ _ _   _  __ _| \  / |_ _ __   ___
 *   / /\ \ / _` | | | |/ _` | |\/| | | '_ \ / _ \
 *  / ____ \ (_| | |_| | (_| | |  | | | | | |  __/
 * /_/    \_\__, |\__,_|\__,_|_|  |_|_|_| |_|\___|
 *             | |
 *             |_|
 *
 * This program is private software. No license required.
 * Publication of this program is forbidden and will be punished.
 *
 * @author GreenWix Project
 * @link https://www.greenwix.fun
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\nbt\tag;

use ArgumentCountError;
use InvalidArgumentException;
use function func_num_args;

/**
 * This trait implements common parts of tags containing integer values.
 */
trait IntegerishTagTrait{

	abstract protected function min() : int;

	abstract protected function max() : int;

	/** @var int */
	private $value;

	public function __construct(int $value){
		if(func_num_args() > 1){
			throw new ArgumentCountError(__METHOD__ . "() expects at most 1 parameters, " . func_num_args() . " given");
		}
		if($value < $this->min() or $value > $this->max()){
			throw new InvalidArgumentException("Value $value is outside the allowed range " . $this->min() . " - " . $this->max());
		}
		$this->value = $value;
	}

	public function getValue() : int{
		return $this->value;
	}

	protected function stringifyValue(int $indentation) : string{
		return (string) $this->value;
	}
}
