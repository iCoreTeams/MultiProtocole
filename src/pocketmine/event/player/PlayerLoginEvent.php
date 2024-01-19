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

use pocketmine\event\Cancellable;
use pocketmine\Player;

/**
 * Called when a player joins, after things have been correctly set up (you can change anything now)
 */
class PlayerLoginEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var string */
	protected $kickMessage;

	/**
	 * @param Player $player
	 * @param string $kickMessage
	 */
	public function __construct(Player $player, string $kickMessage){
		$this->player = $player;
		$this->kickMessage = $kickMessage;
	}

	/**
	 * @param string $kickMessage
	 */
	public function setKickMessage(string $kickMessage){
		$this->kickMessage = $kickMessage;
	}

	/**
	 * @return string
	 */
	public function getKickMessage() : string{
		return $this->kickMessage;
	}

}