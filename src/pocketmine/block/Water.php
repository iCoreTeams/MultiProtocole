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
use pocketmine\item\Item;
use pocketmine\Player;

class Water extends Liquid{

	protected $id = self::FLOWING_WATER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Water";
	}

	public function getLightFilter() : int{
		return 2;
	}

	public function tickRate() : int{
		return 5;
	}

	public function onEntityCollide(Entity $entity):bool{
		$entity->resetFallDistance();
		if($entity->fireTicks > 0){
			$entity->extinguish();
		}

		$entity->resetFallDistance();
        return true;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$ret = $this->getLevel()->setBlock($this, $this, true, false);
		$this->getLevel()->scheduleDelayedBlockUpdate($this, $this->tickRate());

		return $ret;
	}
}
