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

namespace pocketmine\level;

/**
 * If you want to keep chunks loaded, implement this interface and register it into Level. This will also tick chunks.
 *
 * @see Level::registerChunkLoader()
 * @see Level::unregisterChunkLoader()
 *
 * WARNING: When moving this object around in the world or destroying it,
 * be sure to unregister the loader from chunks you're not using, otherwise you'll leak memory.
 */
interface ChunkLoader{

	/**
	 * Returns the ChunkLoader id.
	 * Call Level::generateChunkLoaderId($this) to generate and save it
	 *
	 * @return int
	 */
	public function getLoaderId() : int;

	/**
	 * Returns if the chunk loader is currently active
	 *
	 * @return bool
	 */
	public function isLoaderActive() : bool;

	/**
	 * @return Position
	 */
	public function getPosition();

	/**
	 * @return float
	 */
	public function getX();

	/**
	 * @return float
	 */
	public function getZ();

	/**
	 * @return Level
	 */
	public function getLevel();
}