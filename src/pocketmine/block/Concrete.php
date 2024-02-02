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

class Concrete extends Solid{

    protected $id = self::CONCRETE;

    /**
     * Concrete constructor.
     *
     * @param int $meta
     */
    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function getHardness(){
        return 1.8;
    }

    public function getToolType(){
        return Tool::TYPE_PICKAXE;
    }

    public function getDrops(Item $item){
        if($item->isPickaxe() >= Tool::TIER_WOODEN){
            return [
                [$this->getId(), 0, 1],
            ];
        }else{
            return [];
        }
    }

    /**
     * @return mixed
     */
    public function getName(){
        static $names = [
            0 => "White Concrete",
            1 => "Orange Concrete",
            2 => "Magenta Concrete",
            3 => "Light Blue Concrete",
            4 => "Yellow Concrete",
            5 => "Lime Concrete",
            6 => "Pink Concrete",
            7 => "Gray Concrete",
            8 => "Silver Concrete",
            9 => "Cyan Concrete",
            10 => "Purple Concrete",
            11 => "Blue Concrete",
            12 => "Brown Concrete",
            13 => "Green Concrete",
            14 => "Red Concrete",
            15 => "Black Concrete",
        ];
        return $names[$this->meta & 0x0f];
    }
}