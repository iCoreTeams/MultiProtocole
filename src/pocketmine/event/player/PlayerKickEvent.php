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
use pocketmine\event\TextContainer;
use pocketmine\Player;

/**
 * Called when a player leaves the server
 */
class PlayerKickEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var TextContainer|string */
	protected $quitMessage;

	/** @var string */
	protected $reason;

	/**
	 * PlayerKickEvent constructor.
	 *
	 * @param Player               $player
	 * @param string               $reason
	 * @param TextContainer|string $quitMessage
	 */
	public function __construct(Player $player, string $reason, $quitMessage){
		$this->player = $player;
		$this->quitMessage = $quitMessage;
		$this->reason = $reason;
	}

	public function getReason() : string{
		return $this->reason;
	}

	/**
	 * @param TextContainer|string $quitMessage
	 */
	public function setQuitMessage($quitMessage){
		$this->quitMessage = $quitMessage;
	}

	/**
	 * @return TextContainer|string
	 */
	public function getQuitMessage(){
		return $this->quitMessage;
	}

}