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
 * Called when a player runs a command or chats, early in the process
 *
 * You don't want to use this except for a few cases like logging commands,
 * blocking commands on certain places, or applying modifiers.
 *
 * The message contains a slash at the start
 */
class PlayerCommandPreprocessEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var string */
	protected $message;


	/**
	 * @param Player $player
	 * @param string $message
	 */
	public function __construct(Player $player, $message){
		$this->player = $player;
		$this->message = $message;
	}

	/**
	 * @return string
	 */
	public function getMessage() : string{
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage(string $message){
		$this->message = $message;
	}

	/**
	 * @param Player $player
	 */
	public function setPlayer(Player $player){
		$this->player = $player;
	}

}