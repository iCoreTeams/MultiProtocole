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

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;

use function mt_rand;

class TallGrass extends Flowable{

	protected $id = self::TALL_GRASS;

	public function __construct($meta = 1){
		$this->meta = $meta;
	}

	public function canBeReplaced(){
		return true;
	}

	public function getName(){
		static $names = [
			0 => "Dead Shrub",
			1 => "Tall Grass",
			2 => "Fern",
			3 => ""
		];
		return $names[$this->meta & 0x03];
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(Vector3::SIDE_DOWN);
		if($down->getId() === self::GRASS){
			$this->getLevel()->setBlock($block, $this, true);

			return true;
		}

		return false;
	}


	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(Vector3::SIDE_DOWN)->isTransparent() === true){ //Replace with common break method
				$this->getLevel()->setBlock($this, new Air(), true, true);

				return Level::BLOCK_UPDATE_NORMAL;
			}
		}

		return false;
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_SHEARS;
	}

	public function getToolHarvestLevel() : int{
		return 1;
	}

	public function getDrops(Item $item){
		if(mt_rand(0, 15) === 0){
			return [
				[Item::WHEAT_SEEDS, 0, 1]
			];
		}

		return [];
	}

}
