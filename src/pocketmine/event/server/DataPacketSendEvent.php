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
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\Player;

class DataPacketSendEvent extends ServerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var DataPacket */
	private $packet;
	/** @var Player */
	private $player;

	/**
	 * @param Player $player
	 * @param DataPacket $packet
	 */
	public function __construct(Player $player, DataPacket $packet){
		$this->packet = $packet;
		$this->player = $player;
	}

	/**
	 * @return DataPacket
	 */
	public function getPacket() : DataPacket{
		return $this->packet;
	}

	/**
	 * @return Player
	 */
	public function getPlayer() : Player{
		return $this->player;
	}
}