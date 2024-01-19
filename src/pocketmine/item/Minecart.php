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

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\object\MinecartEmpty;
use pocketmine\level\Level;
use pocketmine\Player;

class Minecart extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::MINECART, $meta, $count, "Minecart");
	}

    public function getMaxStackSize() : int{
        return 1;
    }

    public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
        $minecart = new MinecartEmpty(
            $player->getLevel(),
            EntityDataHelper::createBaseNBT(
                $block->add(0, 0.8, 0),
                null,
                0, 0
            )
        );
        $minecart->spawnToAll();

        if($player->isSurvival()){
            $this->pop();
        }

        return true;
    }

}

