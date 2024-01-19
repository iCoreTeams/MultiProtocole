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


namespace pocketmine\event\level;

use pocketmine\level\Level;
use pocketmine\level\format\Chunk;

/**
 * Called when a Chunk is loaded
 */
class ChunkLoadEvent extends ChunkEvent{
	public static $handlerList = null;

	/** @var bool */
	private $newChunk;

	public function __construct(Level $level, Chunk $chunk, bool $newChunk){
		parent::__construct($level, $chunk);
		$this->newChunk = $newChunk;
	}

	/**
	 * @return bool
	 */
	public function isNewChunk() : bool{
		return $this->newChunk;
	}
}