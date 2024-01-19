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
use pocketmine\entity\EntityDataHelper;
use pocketmine\level\Level;
use pocketmine\Player;
use function lcg_value;

class SpawnEgg extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SPAWN_EGG, $meta, $count, "Spawn Egg");
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$nbt = EntityDataHelper::createBaseNBT($block->add(0.5, 0, 0.5), null, lcg_value() * 360);

		if($this->hasCustomName()){
			$nbt->setString("CustomName", $this->getCustomName());
		}

		$entity = Entity::createEntity($this->meta, $level, $nbt);

		if($entity instanceof Entity){
			if($player->isSurvival()){
				--$this->count;
			}
			$entity->spawnToAll();
			return true;
		}

		return false;
	}
}
