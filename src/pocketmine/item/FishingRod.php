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

use pocketmine\entity\Entity;
use pocketmine\entity\projectile\FishingHook;
use pocketmine\event\player\fish\FishingRodStartFishingEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class FishingRod extends Durable{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::FISHING_ROD, $meta, $count, "Fishing Rod");
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	public function getMaxDurability() : int{
		return 385;
	}

	public function onClickAir(Player $player, Vector3 $directionVector) : bool{
		$hook = $player->getFishingHook();
		if($hook === null or $hook->isFlaggedForDespawn()){
			$hook = new FishingHook($player->level, Entity::createBaseNBT($player->add(0, $player->getEyeHeight(), 0)), $player);

			$ev = new FishingRodStartFishingEvent($player, $hook, 1.0, 0.75, 1.0);
			$ev->call();

			if(!$ev->isCancelled()){
				$hook->setMotion($directionVector->normalize()->multiply($ev->getForce()));

				$player->setFishingHook($hook);
				$hook->handleHookCasting($hook->motionX, $hook->motionY, $hook->motionZ, $ev->getF1(), $ev->getF2());

				$player->level->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_THROW, 0, 0x13f); //Yay! Magic numbers
				$hook->spawnToAll();
			}else{
				$hook->flagForDespawn();
			}
		}else{
			$damage = $hook->handleHookRetraction();

			if($player->isSurvival() and $damage !== 0){
				$this->applyDamage($damage);
				$player->getInventory()->setItemInHand($this);
			}
		}
		return true;
	}
}