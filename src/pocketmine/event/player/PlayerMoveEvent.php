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
use pocketmine\level\Location;
use pocketmine\Player;

class PlayerMoveEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Location */
	private $from;
	/** @var Location */
	private $to;

	/**
	 * @param Player $player
	 * @param Location $from
	 * @param Location $to
	 */
	public function __construct(Player $player, Location $from, Location $to){
		$this->player = $player;
		$this->from = $from;
		$this->to = $to;
	}

	/**
	 * @return Location
	 */
	public function getFrom() : Location{
		return $this->from;
	}

	/**
	 * @param Location $from
	 */
	public function setFrom(Location $from){
		$this->from = $from;
	}

	/**
	 * @return Location
	 */
	public function getTo() : Location{
		return $this->to;
	}

	/**
	 * @param Location $to
	 */
	public function setTo(Location $to){
		$this->to = $to;
	}
}