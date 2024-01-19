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
use function func_num_args;

final class FloatTag extends ImmutableTag{
	/** @var float */
	private $value;

	public function __construct(float $value){
		self::restrictArgCount(__METHOD__, func_num_args(), 1);
		$this->value = $value;
	}

	protected function getTypeName() : string{
		return "Float";
	}

	public function getType() : int{
		return NBT::TAG_Float;
	}

	public static function read(NbtStreamReader $reader) : self{
		return new self($reader->readFloat());
	}

	public function write(NbtStreamWriter $writer) : void{
		$writer->writeFloat($this->value);
	}

	public function getValue() : float{
		return $this->value;
	}

	protected function stringifyValue(int $indentation) : string{
		return (string) $this->value;
	}
}
