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


namespace pocketmine\resourcepacks;


interface ResourcePack{

	/**
	 * Returns the human-readable name of the resource pack
	 * @return string
	 */
	public function getPackName() : string;

	/**
	 * Returns the pack's UUID as a human-readable string
	 * @return string
	 */
	public function getPackId() : string;

	/**
	 * Returns the size of the pack on disk in bytes.
	 * @return int
	 */
	public function getPackSize() : int;

	/**
	 * Returns a version number for the pack in the format major.minor.patch
	 * @return string
	 */
	public function getPackVersion() : string;

	/**
	 * Returns the raw SHA256 sum of the compressed resource pack zip. This is used by clients to validate pack downloads.
	 * @return string byte-array length 32 bytes
	 */
	public function getSha256() : string;

	/**
	 * Returns a chunk of the resource pack zip as a byte-array for sending to clients.
	 *
	 * Note that resource packs must **always** be in zip archive format for sending.
	 * A folder resource loader may need to perform on-the-fly compression for this purpose.
	 *
	 * @param int $start Offset to start reading the chunk from
	 * @param int $length Maximum length of data to return.
	 *
	 * @return string byte-array
	 */
	public function getPackChunk(int $start, int $length) : string;
}