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

/**
 * Class used for Items that can be Blocks
 */
class ItemBlock extends Item{
	public function __construct(Block $block, $meta = 0, int $count = 1){
		$this->block = $block;
		parent::__construct($block->getId(), $block->getDamage(), $count, $block->getName());
	}

	public function setDamage(int $meta){
		$this->meta = $meta !== -1 ? $meta & 0xf : -1;
		$this->block->setDamage($this->meta !== -1 ? $this->meta : 0);
	}

	public function getBlock() : Block{
		return $this->block;
	}

}