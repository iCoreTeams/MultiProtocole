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
use pocketmine\entity\Entity;

class Sword extends TieredTool{

    public function getBlockToolType() : int{
        return Tool::TYPE_SWORD;
    }

    public function getAttackPoints() : int{
        return self::getBaseDamageFromTier($this->tier);
    }

    public function getBlockToolHarvestLevel() : int{
        return 1;
    }

    public function getMiningEfficiency(Block $block) : float{
        return parent::getMiningEfficiency($block) * 1.5; //swords break any block 1.5x faster than hand
    }

    protected function getBaseMiningEfficiency() : float{
        return 10;
    }

    public function onDestroyBlock(Block $block) : bool{
        if($block->getHardness() > 0){
            return $this->applyDamage(2);
        }
        return false;
    }

    public function onAttackEntity(Entity $victim) : bool{
        return $this->applyDamage(1);
    }

    public function isSword() {
		return $this->tier;
	}
}