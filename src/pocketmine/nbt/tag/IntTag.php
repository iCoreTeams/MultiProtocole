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

final class IntTag extends ImmutableTag{
	use IntegerishTagTrait;

	protected function min() : int{
		return -0x7fffffff - 1; //workaround parser bug https://bugs.php.net/bug.php?id=53934
	}

	protected function max() : int{ return 0x7fffffff; }

	protected function getTypeName() : string{
		return "Int";
	}

	public function getType() : int{
		return NBT::TAG_Int;
	}

	public static function read(NbtStreamReader $reader) : self{
		return new self($reader->readInt());
	}

	public function write(NbtStreamWriter $writer) : void{
		$writer->writeInt($this->value);
	}
}
