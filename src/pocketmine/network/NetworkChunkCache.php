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

namespace pocketmine\network;

use pocketmine\Player;

interface NetworkChunkCache{

	/**
	 * Requests asynchronous preparation of the chunk at the given coordinates.
	 *
	 * @param Player $player
	 * @param int    $chunkX
	 * @param int    $chunkZ
	 */
	public function request(Player $player, int $chunkX, int $chunkZ) : void;

	/**
	 * @param Player $player
	 * @param int    $chunkX
	 * @param int    $chunkZ
	 */
	public function unregister(Player $player, int $chunkX, int $chunkZ) : void;

	/**
	 * Returns the number of bytes occupied by the cache data in this cache.
	 *
	 * @return int
	 */
	public function calculateCacheSize() : int;
}