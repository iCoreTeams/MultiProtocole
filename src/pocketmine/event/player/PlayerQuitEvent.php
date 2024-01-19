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

use pocketmine\event\TranslationContainer;
use pocketmine\Player;

/**
 * Called when a player leaves the server
 */
class PlayerQuitEvent extends PlayerEvent{
	public static $handlerList = null;

	/** @var TranslationContainer|string */
	protected $quitMessage;
	/** @var string */
	protected $reason;

	/**
	 * @param Player                      $player
	 * @param TranslationContainer|string $quitMessage
	 * @param string                      $reason
	 */
	public function __construct(Player $player, $quitMessage, string $reason){
		$this->player = $player;
		$this->quitMessage = $quitMessage;
		$this->reason = $reason;
	}

	/**
	 * @param TranslationContainer|string $quitMessage
	 */
	public function setQuitMessage($quitMessage){
		$this->quitMessage = $quitMessage;
	}

	/**
	 * @return TranslationContainer|string
	 */
	public function getQuitMessage(){
		return $this->quitMessage;
	}

	/**
	 * @return string
	 */
	public function getReason() : string{
		return $this->reason;
	}
}
