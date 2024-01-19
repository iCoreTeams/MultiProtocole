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
use function base64_encode;
use function func_num_args;

final class ByteArrayTag extends ImmutableTag{
	/** @var string */
	private $value;

	public function __construct(string $value){
		self::restrictArgCount(__METHOD__, func_num_args(), 1);
		$this->value = $value;
	}

	protected function getTypeName() : string{
		return "ByteArray";
	}

	public function getType() : int{
		return NBT::TAG_ByteArray;
	}

	public static function read(NbtStreamReader $reader) : self{
		return new self($reader->readByteArray());
	}

	public function write(NbtStreamWriter $writer) : void{
		$writer->writeByteArray($this->value);
	}

	public function getValue() : string{
		return $this->value;
	}

	protected function stringifyValue(int $indentation) : string{
		return "b64:" . base64_encode($this->value);
	}
}
