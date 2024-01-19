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


namespace pocketmine\event\player\cheat;

use pocketmine\event\Cancellable;
use pocketmine\Player;
use pocketmine\math\Vector3;

/**
 * Called when a player attempts to perform movement cheats such as clipping through blocks.
 */
class PlayerIllegalMoveEvent extends PlayerCheatEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Vector3 */
	private $attemptedPosition;

	/**
	 * @param Player  $player
	 * @param Vector3 $attemptedPosition
	 */
	public function __construct(Player $player, Vector3 $attemptedPosition){
		$this->attemptedPosition = $attemptedPosition;
		$this->player = $player;
	}

	/**
	 * Returns the position the player attempted to move to.
	 * @return Vector3
	 */
	public function getAttemptedPosition() : Vector3{
		return $this->attemptedPosition;
	}

}