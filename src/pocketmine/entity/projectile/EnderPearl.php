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

namespace pocketmine\entity\projectile;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityEnderPearlEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\level\Level;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Player;

class EnderPearl extends Throwable{
	public const NETWORK_ID = self::ENDER_PEARL;

	public function __construct(Level $level, CompoundTag $nbt, Entity $shootingEntity = null){
		parent::__construct($level, $nbt, $shootingEntity);
	}

	public function onHit(ProjectileHitEvent $event) : void{
		$to = $event->getRayTraceResult()->getHitVector();
		if($this->shootingEntity instanceof Player and $this->shootingEntity->isAlive() and $to->y > 0){
			$ev = new EntityEnderPearlEvent($owner = $this->shootingEntity, $this, $to);
			$ev->call();

			if(!$ev->isCancelled()){
				$this->level->broadcastLevelEvent($owner, LevelEventPacket::EVENT_PARTICLE_ENDERMAN_TELEPORT);
				$this->level->addSound(new EndermanTeleportSound($owner));

				$owner->teleport($to);
				$this->level->addSound(new EndermanTeleportSound($owner));

				$ev = new EntityDamageEvent($owner, EntityDamageEvent::CAUSE_FALL, 5);
				$owner->attack($ev);
			}
		}

		$this->flagForDespawn();
	}
}
