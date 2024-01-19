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

/**
 * All the Object populator classes
 */
namespace pocketmine\level\generator\populator;

use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

abstract class Populator{

	/**
	 * @param ChunkManager $level
	 * @param int $chunkX
	 * @param int $chunkZ
	 * @param Random $random
	 *
	 * @return mixed
	 */
	abstract public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random);
}