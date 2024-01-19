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

use pocketmine\block\Block;

class Potato extends Food{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Block::POTATO_BLOCK);
		parent::__construct(self::POTATO, $meta, $count, "Potato");
	}

	public function getFoodRestore() : int{
		return 1;
	}

	public function getSaturationRestore() : float{
		return 0.6;
	}
}