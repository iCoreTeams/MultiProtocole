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
use pocketmine\math\Vector3;
use pocketmine\Player;

class PlayerPreMoveEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Vector3 */
	private $from;
	/** @var Vector3 */
	private $to;

	/**
	 * @param Player $player
	 * @param Vector3 $from
	 * @param Vector3 $to
	 */
	public function __construct(Player $player, Vector3 $from, Vector3 $to){
		$this->player = $player;
		$this->from = $from;
		$this->to = $to;
	}

	/**
	 * @return Vector3
	 */
	public function getFrom() : Vector3{
		return $this->from;
	}

	/**
	 * @return Vector3
	 */
	public function getTo() : Vector3{
		return $this->to;
	}

	/**
	 * @param Vector3 $to
	 */
	public function setTo(Vector3 $to){
		$this->to = $to;
	}
}