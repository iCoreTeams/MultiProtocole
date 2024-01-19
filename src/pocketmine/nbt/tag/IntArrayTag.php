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

use pocketmine\nbt\NBT;
use pocketmine\nbt\NbtStreamReader;
use pocketmine\nbt\NbtStreamWriter;
use function assert;
use function func_num_args;
use function implode;
use function is_int;

final class IntArrayTag extends ImmutableTag{
	/** @var int[] */
	private $value;

	/**
	 * @param int[] $value
	 */
	public function __construct(array $value){
		self::restrictArgCount(__METHOD__, func_num_args(), 1);
		assert((function() use(&$value) : bool{
			foreach($value as $v){
				if(!is_int($v)){
					return false;
				}
			}

			return true;
		})());

		$this->value = $value;
	}

	protected function getTypeName() : string{
		return "IntArray";
	}

	public function getType() : int{
		return NBT::TAG_IntArray;
	}

	public static function read(NbtStreamReader $reader) : self{
		return new self($reader->readIntArray());
	}

	public function write(NbtStreamWriter $writer) : void{
		$writer->writeIntArray($this->value);
	}

	protected function stringifyValue(int $indentation) : string{
		return "[" . implode(",", $this->value) . "]";
	}

	/**
	 * @return int[]
	 */
	public function getValue() : array{
		return $this->value;
	}
}
