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

class Lever extends Flowable{

	protected $id = self::LEVER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Lever";
	}

    public function onUpdate($type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            $side = $this->getDamage();
            if($this->isActivated()) $side ^= 0x08;
            $faces = [
                5 => 0,
                6 => 0,
                3 => 2,
                1 => 4,
                4 => 3,
                2 => 5,
                0 => 1,
                7 => 1,
            ];

            $block = $this->getSide($faces[$side]);
            if($block->isTransparent()){
                $this->getLevel()->useBreakOn($this);

                return Level::BLOCK_UPDATE_NORMAL;
            }
        }
        return false;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if($target->isTransparent() === false){
            $faces = [
                3 => 3,
                2 => 4,
                4 => 2,
                5 => 1,
            ];
            if($face === 0){
                $to = $player instanceof Player ? $player->getDirection() : 0;
                $this->meta = ($to % 2 != 1 ? 0 : 7);
            }elseif($face === 1){
                $to = $player instanceof Player ? $player->getDirection() : 0;
                $this->meta = ($to % 2 != 1 ? 6 : 5);
            }else{
                $this->meta = $faces[$face];
            }

            $this->getLevel()->setBlock($block, $this, true, false);
            return true;
        }

        return false;
    }

    /**
     * @param Item $item
     * @param Player|null $player
     *
     * @return bool
     */
    public function onActivate(Item $item, Player $player = null){
        $this->meta ^= 0x08;
        $this->getLevel()->setBlock($this, $this, true, false);
        $this->getLevel()->addSound(new ButtonClickSound($this));
        return true;
    }

    /**
     * @param Item $item
     *
     * @return mixed|void
     */
    public function onBreak(Item $item, Player $player = null) : bool{
        if($this->isActivated()){
            $this->meta ^= 0x08;
            $this->getLevel()->setBlock($this, $this, true, false);
        }
        $this->getLevel()->setBlock($this, Block::get(Block::AIR), true, false);
        return true;
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
     * @return float
     */
    public function getHardness(){
        return 0.5;
    }

    /**
     * @return float
     */
    public function getResistance(): float
    {
        return 2.5;
    }

    /**
     * @param Item $item
     *
     * @return array
     */
    public function getDrops(Item $item) : array{
        return [
            [$this->id, 0, 1],
        ];
    }
}
