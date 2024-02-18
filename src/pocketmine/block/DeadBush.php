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

class DeadBush extends Flowable{

	protected $id = self::DEAD_BUSH;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Dead Bush";
	}

    /**
     * @param Item        $item
     * @param Block       $block
     * @param Block       $target
     * @param int         $face
     * @param float       $fx
     * @param float       $fy
     * @param float       $fz
     * @param Player|null $player
     *
     * @return bool
     */
    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        $down = $this->getSide(0);
        if($down->getId() === Block::SAND or $down->getId() === Block::PODZOL or
            $down->getId() === Block::HARDENED_CLAY or $down->getId() === Block::STAINED_CLAY
        ){
            $this->getLevel()->setBlock($block, $this, true);
            return true;
        }
        return false;
    }

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(Vector3::SIDE_DOWN)->isTransparent() === true){
				$this->getLevel()->useBreakOn($this);

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

    /**
     * @param Item $item
     *
     * @return array
     */
    public function getDrops(Item $item) : array{
        if($item->isShears()){
            return [
                [Item::DEAD_BUSH, 0, 1],
            ];
        }else{
            return [
                [Item::STICK, 0, mt_rand(0, 2)],
            ];
        }

    }

}