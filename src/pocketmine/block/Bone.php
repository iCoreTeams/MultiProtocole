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
use pocketmine\item\Tool;
use pocketmine\Player;

class Bone extends Solid{

    protected $id = self::BONE_BLOCK;

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if($face == 2 || $face == 3){
            $this->meta = 2;
        }elseif($face == 4 || $face == 5){
            $this->meta = 3;
        }
        $this->getLevel()->setBlock($block, $this, true);
    }

    public function getName(){
        return "Bone";
    }

    public function getHardness(){
        return 2;
    }

    public function getBlastResistance(): float
    {
        return 10;
    }

    public function getToolType(){
        return Tool::TYPE_PICKAXE;
    }
}