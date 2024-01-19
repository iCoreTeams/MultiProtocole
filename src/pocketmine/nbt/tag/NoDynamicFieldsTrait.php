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

use RuntimeException;
use function get_class;

trait NoDynamicFieldsTrait{

	private function throw(string $field) : RuntimeException{
		return new RuntimeException("Cannot access dynamic field \"$field\": Dynamic field access on " . get_class($this) . " is no longer supported");
	}

	/**
	 * @param string $name
	 *
	 * @phpstan-return never
	 */
	public function __get(string $name){
		throw $this->throw($name);
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 *
	 * @phpstan-return never
	 */
	public function __set(string $name, $value){
		throw $this->throw($name);
	}

	/**
	 * @param string $name
	 *
	 * @phpstan-return never
	 */
	public function __isset(string $name){
		throw $this->throw($name);
	}

	/**
	 * @param string $name
	 *
	 * @phpstan-return never
	 */
	public function __unset(string $name){
		throw $this->throw($name);
	}
}
