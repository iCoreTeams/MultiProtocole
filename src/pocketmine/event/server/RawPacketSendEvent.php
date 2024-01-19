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

namespace pocketmine\event\server;

use pocketmine\event\Cancellable;
use pocketmine\Player;

class RawPacketSendEvent extends ServerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Player */
	private $player;
	/** @var string */
	private $buffer;

	/**
	 * @param Player $player
	 * @param string $buffer
	 */
	public function __construct(Player $player, string $buffer){
		$this->player = $player;
		$this->buffer = $buffer;
	}

	/**
	 * @return Player
	 */
	public function getPlayer() : Player{
		return $this->player;
	}

	/**
	 * @return string
	 */
	public function getBuffer() : string{
		return $this->buffer;
	}
}