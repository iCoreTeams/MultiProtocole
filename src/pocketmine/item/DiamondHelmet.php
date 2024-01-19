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


class DiamondHelmet extends Armor{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_HELMET, $meta, $count, "Diamond Helmet");
	}

	public function getArmorPoints() : int{
		return 3;
	}

	public function getArmorHash() : int{
		return $this->getDiamondArmorPoints();
	}

	public function getMaxDurability() : int{
		return 364;
	}
}