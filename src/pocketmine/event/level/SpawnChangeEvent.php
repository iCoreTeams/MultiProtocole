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
use pocketmine\level\Position;

/**
 * An event that is called when a level spawn changes.
 * The previous spawn is included
 */
class SpawnChangeEvent extends LevelEvent{
	public static $handlerList = null;

	/** @var Position */
	private $previousSpawn;

	/**
	 * @param Level    $level
	 * @param Position $previousSpawn
	 */
	public function __construct(Level $level, Position $previousSpawn){
		parent::__construct($level);
		$this->previousSpawn = $previousSpawn;
	}

	/**
	 * @return Position
	 */
	public function getPreviousSpawn() : Position{
		return $this->previousSpawn;
	}
}