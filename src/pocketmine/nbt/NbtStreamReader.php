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

use pocketmine\utils\BinaryDataException;

/**
 * @internal
 */
interface NbtStreamReader{

	/**
	 * @throws BinaryDataException
	 */
	public function readByte() : int;

	/**
	 * @throws BinaryDataException
	 */
	public function readSignedByte() : int;

	/**
	 * @throws BinaryDataException
	 */
	public function readShort() : int;

	/**
	 * @throws BinaryDataException
	 */
	public function readSignedShort() : int;

	/**
	 * @throws BinaryDataException
	 */
	public function readInt() : int;

	/**
	 * @throws BinaryDataException
	 */
	public function readLong() : int;

	/**
	 * @throws BinaryDataException
	 */
	public function readFloat() : float;

	/**
	 * @throws BinaryDataException
	 */
	public function readDouble() : float;

	/**
	 * @throws BinaryDataException
	 */
	public function readByteArray() : string;

	/**
	 * @throws BinaryDataException
	 */
	public function readString() : string;

	/**
	 * @return int[]
	 * @throws BinaryDataException
	 */
	public function readIntArray() : array;
}
