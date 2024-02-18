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
use pocketmine\level\sound\ButtonClickSound;
use pocketmine\math\Vector3;
use pocketmine\Player;

abstract class Button extends Flowable{

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

    public function onUpdate($type){
        if($type == Level::BLOCK_UPDATE_SCHEDULED){
            if($this->isActivated()){
                $this->meta ^= 0x08;
                $this->getLevel()->setBlock($this, $this, true, false);
                $this->getLevel()->addSound(new ButtonClickSound($this));
            }
            return Level::BLOCK_UPDATE_SCHEDULED;
        }
        if($type === Level::BLOCK_UPDATE_NORMAL){
            $side = $this->getDamage();
            if($this->isActivated()) $side ^= 0x08;
            $faces = [
                0 => 1,
                1 => 0,
                2 => 3,
                3 => 2,
                4 => 5,
                5 => 4,
            ];

            if($this->getSide($faces[$side]) instanceof Transparent){
                $this->getLevel()->useBreakOn($this);

                return Level::BLOCK_UPDATE_NORMAL;
            }
        }
        return false;
    }

    /**
     * @param Item $item
     *
     * @return mixed|void
     */
    public function onBreak(Item $item){
        if($this->isActivated()){
            $this->meta ^= 0x08;
            $this->getLevel()->setBlock($this, $this, true, false);
        }
        $this->getLevel()->setBlock($this, new Air(), true, false);
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if($target->isTransparent() === false){
            $this->meta = $face;
            $this->getLevel()->setBlock($block, $this, true, false);
            return true;
        }
        return false;
    }

    /**
     * @param Block|null $from
     *
     * @return bool
     */
    public function isActivated(Block $from = null){
        return (($this->meta & 0x08) === 0x08);
    }

    /**
     * @param Item        $item
     * @param Player|null $player
     *
     * @return bool
     */
    public function onActivate(Item $item, Player $player = null){
        if(!$this->isActivated()){
            $this->meta ^= 0x08;
            $this->getLevel()->setBlock($this, $this, true, false);
            $this->getLevel()->addSound(new ButtonClickSound($this));
            $this->getLevel()->scheduleUpdate($this, 30);
        }
        return true;
    }

	public function canBeActivated() : bool{
		return true;
	}
}
