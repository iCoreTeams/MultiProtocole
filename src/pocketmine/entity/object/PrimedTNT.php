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

namespace pocketmine\entity\object;

use pocketmine\entity\Entity;
use pocketmine\entity\Explosive;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class PrimedTNT extends Entity implements Explosive{
	public const NETWORK_ID = self::TNT;

	public float $width = 0.98;
	public float $height = 0.98;

	protected float $baseOffset = 0.49;

	public float $gravity = 0.04;
	public float $drag = 0.02;

	protected $fuse;

	public bool $canCollide = false;


	public function attack(EntityDamageEvent $source){
		if($source->getCause() === EntityDamageEvent::CAUSE_VOID){
			parent::attack($source);
		}
	}

	protected function initEntity(){
		parent::initEntity();

		$this->fuse = $this->namedtag->getByte("Fuse", 80);

		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_IGNITED, true);
		$this->setDataProperty(self::DATA_FUSE_LENGTH, self::DATA_TYPE_INT, $this->fuse);

		$this->level->broadcastLevelEvent($this, LevelEventPacket::EVENT_SOUND_IGNITE);
	}


	public function canCollideWith(Entity $entity){
		return false;
	}

	public function saveNBT(){
		parent::saveNBT();
		$this->namedtag->setByte("Fuse", $this->fuse);
	}

	public function entityBaseTick($tickDiff = 1){
		if($this->closed){
			return false;
		}

		$hasUpdate = parent::entityBaseTick($tickDiff);

		if($this->fuse % 5 === 0){ //don't spam it every tick, it's not necessary
			$this->setDataProperty(self::DATA_FUSE_LENGTH, self::DATA_TYPE_INT, $this->fuse);
		}

		if(!$this->isFlaggedForDespawn()){
			$this->fuse -= $tickDiff;

			if($this->fuse <= 0){
				$this->flagForDespawn();
				$this->explode();
			}
		}

		return $hasUpdate or $this->fuse >= 0;
	}

	public function explode(){
		$ev = new ExplosionPrimeEvent($this, 4);
		$ev->call();

		if(!$ev->isCancelled()){
			$explosion = new Explosion($this, $ev->getForce(), $this);
			if($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}
}
