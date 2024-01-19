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
 * Chunk-related events
 */
abstract class ChunkEvent extends LevelEvent{
	/** @var Chunk */
	private $chunk;

	/**
	 * @param Level $level
	 * @param Chunk $chunk
	 */
	public function __construct(Level $level, Chunk $chunk){
		parent::__construct($level);
		$this->chunk = $chunk;
	}

	/**
	 * @return Chunk
	 */
	public function getChunk() : Chunk{
		return $this->chunk;
	}
}