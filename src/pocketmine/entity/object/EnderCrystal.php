<?php

declare(strict_types=1);

namespace pocketmine\entity\object;

use pocketmine\entity\Entity;
use pocketmine\entity\Explosive;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class EnderCrystal extends Entity implements Explosive{

	public const NETWORK_ID = self::ENDER_CRYSTAL;

	public float $height = 0.98;
	public float $width = 0.98;
	public float $gravity = 0.5;
	public float $drag = 0.1;

	public function __construct(Level $level, CompoundTag $nbt){
		parent::__construct($level, $nbt);
		$this->setMaxHealth(1);
		$this->setHealth(1);
	}

	/**
	 * @return string
	 */
	public function getName() : string{
		return "Ender Crystal";
	}

    public function isFireProof(): bool{
        return true;
    }

    public function attack(EntityDamageEvent $source){
		parent::attack($source);
        if(
            $source->getCause() !== EntityDamageEvent::CAUSE_VOID &&
            !$this->isFlaggedForDespawn() &&
            !$source->isCancelled()
        ){
            $this->flagForDespawn();
            $this->explode();
        }
	}

	public function explode(){
		$ev = new ExplosionPrimeEvent($this, 6); //TODO: dropitem зависит от того, в креативе ли игрок
        $ev->call();
		if(!$ev->isCancelled()){
			$explosion = new Explosion(Position::fromObject($this->add(0, $this->height / 2, 0), $this->level), $ev->getForce(), $this);
			if($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}

	public function sendSpawnPacket(Player $player):void{
		$pk = new AddEntityPacket();
		$pk->entityRuntimeId = $this->getId();
		$pk->type = self::NETWORK_ID;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = 0;
		$pk->speedY = 0;
		$pk->speedZ = 0;
		$pk->yaw = 0;
		$pk->pitch = 0;
		$pk->metadata = $this->dataProperties;
		$player->sendDataPacket($pk);
	}
}