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

use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\event\entity\EntityEatItemEvent;
use pocketmine\network\mcpe\protocol\EntityEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

abstract class Food extends Item implements FoodSource{
	public function canBeConsumed() : bool{
		return true;
	}

	public function canBeConsumedBy(Entity $entity) : bool{
		return $entity instanceof Human and $entity->getFood() < $entity->getMaxFood();
	}

	public function getResidue(){
		if($this->getCount() === 1){
			return Item::get(0);
		}else{
			$new = clone $this;
			$new->count--;
			return $new;
		}
	}

	public function getAdditionalEffects() : array{
		return [];
	}

	public function onConsume(Entity $human){
        assert($human instanceof Human);
        $human->level->broadcastLevelSoundEvent($human->add(0, $human->getEyeHeight(), 0), LevelSoundEventPacket::SOUND_BURP);

		$ev = new EntityEatItemEvent($human, $this);

		$human->addSaturation($ev->getSaturationRestore());
		$human->addFood($ev->getFoodRestore());
		foreach($ev->getAdditionalEffects() as $effect){
			$human->addEffect($effect);
		}

		$human->getInventory()->setItemInHand($ev->getResidue());
	}
}
