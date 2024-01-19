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
use pocketmine\block\Fire;
use pocketmine\block\Solid;
use pocketmine\level\Level;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class FlintSteel extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::FLINT_STEEL, $meta, $count, "Flint and Steel");
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($block->getId() === self::AIR and ($target instanceof Solid)){
			$level->setBlock($block, new Fire(), true);
			$level->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_IGNITE);
			if(($player->gamemode & 0x01) === 0){
				$this->applyDamage(1);
				$player->getInventory()->setItemInHand($this);
			}

			return true;
		}

		return false;
	}
}