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

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\item\FoodSource;
use pocketmine\item\Item;

class EntityEatItemEvent extends EntityEatEvent{
	public function __construct(Entity $entity, FoodSource $foodSource){
		parent::__construct($entity, $foodSource);
	}

	/**
	 * @return Item
	 */
	public function getResidue(){
		return parent::getResidue();
	}

	public function setResidue($residue){
		if(!($residue instanceof Item)){
			throw new \InvalidArgumentException("Eating an Item can only result in an Item residue");
		}
		parent::setResidue($residue);
	}
}
