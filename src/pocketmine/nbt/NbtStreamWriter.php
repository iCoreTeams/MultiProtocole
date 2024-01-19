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

namespace pocketmine\nbt;

use InvalidArgumentException;

/**
 * @internal
 */
interface NbtStreamWriter{

	public function writeByte(int $v) : void;

	public function writeShort(int $v) : void;

	public function writeInt(int $v) : void;

	public function writeLong(int $v) : void;

	public function writeFloat(float $v) : void;

	public function writeDouble(float $v) : void;

	public function writeByteArray(string $v) : void;

	/**
	 * @param string $v
	 *
	 * @throws InvalidArgumentException if the string is too long
	 */
	public function writeString(string $v) : void;

	/**
	 * @param int[] $array
	 */
	public function writeIntArray(array $array) : void;
}
