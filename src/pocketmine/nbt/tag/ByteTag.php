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

final class ByteTag extends ImmutableTag{
	use IntegerishTagTrait;

	protected function min() : int{ return -0x80; }

	protected function max() : int{ return 0x7f; }

	protected function getTypeName() : string{
		return "Byte";
	}

	public function getType() : int{
		return NBT::TAG_Byte;
	}

	public static function read(NbtStreamReader $reader) : self{
		return new self($reader->readSignedByte());
	}

	public function write(NbtStreamWriter $writer) : void{
		$writer->writeByte($this->value);
	}
}
