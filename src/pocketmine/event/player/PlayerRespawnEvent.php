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

namespace pocketmine\event\player;

use pocketmine\level\Position;
use pocketmine\Player;

/**
 * Called when a player is respawned (or first time spawned)
 */
class PlayerRespawnEvent extends PlayerEvent{
	public static $handlerList = null;

	/** @var Position */
	protected $position;

	/**
	 * @param Player   $player
	 * @param Position $position
	 */
	public function __construct(Player $player, Position $position){
		$this->player = $player;
		$this->position = $position;
	}

	/**
	 * @return Position
	 */
	public function getRespawnPosition() : Position{
		return $this->position;
	}

	/**
	 * @param Position $position
	 */
	public function setRespawnPosition(Position $position){
		$this->position = $position;
	}
}