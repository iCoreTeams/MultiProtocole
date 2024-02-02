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

class RedNetherBrick extends NetherBrick {

    protected $id = self::RED_NETHER_BRICK;

    public function getName(){
        return "Red Nether Brick";
    }

    public function getDrops(Item $item){
        if($item->isPickaxe() >= Tool::TIER_WOODEN){
            return [
                [Item::RED_NETHER_BRICK, 0, 1],
            ];
        }else{
            return [];
        }
    }
}