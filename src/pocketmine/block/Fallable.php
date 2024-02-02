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

namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\level\Level;
use pocketmine\math\Vector3;

abstract class Fallable extends Solid{

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$down = $this->getSide(Vector3::SIDE_DOWN);
			if($down->getId() === self::AIR or ($down instanceof Liquid)){
				$this->level->setBlock($this, Block::get(Block::AIR), true, true);

				$nbt = EntityDataHelper::createBaseNBT($this->add(0.5, 0, 0.5));
				$nbt->setInt("TileID", $this->getId());
				$nbt->setByte("Data", $this->getDamage());

				$fall = Entity::createEntity("FallingBlock", $this->getLevel(), $nbt);

				$fall->spawnToAll();
			}
		}
	}
}