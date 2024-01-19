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

namespace pocketmine\level\light;

class BlockLightUpdate extends LightUpdate{

	public function getLight(int $x, int $y, int $z) : int{
		return $this->subChunkHandler->currentSubChunk->getBlockLight($x & 0x0f, $y & 0x0f, $z & 0x0f);
	}

	public function setLight(int $x, int $y, int $z, int $level){
		$this->subChunkHandler->currentSubChunk->setBlockLight($x & 0x0f, $y & 0x0f, $z & 0x0f, $level);
	}
}