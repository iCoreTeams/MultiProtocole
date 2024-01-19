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

namespace pocketmine\event\player\fish;

use pocketmine\entity\FishingHook;
use pocketmine\event\Cancellable;
use pocketmine\event\player\PlayerEvent;
use pocketmine\Player;

class FishingRodCaughtFishEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var FishingHook */
	protected $hook;

	public function __construct(Player $fisher, FishingHook $hook){
		$this->player = $fisher;
		$this->hook = $hook;
	}
	/**
	 * @return FishingHook
	 */
	public function getHook() : FishingHook{
		return $this->hook;
	}
}