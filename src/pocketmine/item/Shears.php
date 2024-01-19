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

class Shears extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SHEARS, $meta, $count, "Shears");
	}

	public function getMaxDurability() : int{
		return 239;
	}

	public function getBlockToolType(): int {
		return Tool::TYPE_SHEARS;
	}

	public function getBlockToolHarvestLevel() : int{
		return 1;
	}

	protected function getBaseMiningEfficiency() : float{
        return 15;
    }

	public function onDestroyBlock(Block $block) : bool{
		if($block->getHardness() === 0.0 or $block->isCompatibleWithTool($this)){
			return $this->applyDamage(1);
		}
		return false;
	}

	public function isShears() {
		return true;
	}
}