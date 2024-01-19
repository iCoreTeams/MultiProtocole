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

namespace pocketmine\item;

use pocketmine\math\Vector3;
use pocketmine\Player;

class Elytra extends Durable{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ELYTRA, $meta, $count, "Elytra");
	}

	public function canBeUsedOnAir() : bool{
		return true;
	}

	public function onClickAir(Player $player, Vector3 $directionVector) : bool{
		if($player->getInventory()->getChestplate()->getId() === Item::AIR){
			$player->getInventory()->setChestplate($this);
			$player->getInventory()->setItemInHand(Item::get(Item::AIR));
		}
		return true;
	}

	public function getMaxDurability(){
		return 431;
	}
}
