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
use pocketmine\item\Tool;

class Cobweb extends Flowable{

	protected $id = self::COBWEB;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function hasEntityCollision(){
		return true;
	}

	public function getName(){
		return "Cobweb";
	}

	public function getHardness(){
		return 4;
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_SWORD | BlockToolType::TYPE_SHEARS;
	}

	public function getToolHarvestLevel() : int{
		return 1;
	}

	public function onEntityCollide(Entity $entity){
		$entity->resetFallDistance();
	}

	public function getDrops(Item $item){
		//TODO: correct drops
		return [];
	}

	public function diffusesSkyLight() : bool{
		return true;
	}
}