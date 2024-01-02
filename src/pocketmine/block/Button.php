<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

abstract class Button extends Flowable{

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if($target->isTransparent()){
            return false;
        }
		//TODO: check valid target block
		$this->meta = $face;

		return $this->level->setBlock($this, $this, true, true);
	}

    public function onActivate(Item $item, Player $player = null){
        if($this->isActivated()){
            return false;
        }

        $this->setDamage($this->getDamage() ^ 0x08);
        $this->level->setBlock($this, $this, true, false);
        $this->level->broadcastLevelSoundEvent($this->add(0.5, 0.5, 0.5), LevelSoundEventPacket::SOUND_POWER_ON, $this->getId());
        $this->level->scheduleDelayedBlockUpdate($this, 30);

        return true;
    }

    public function onUpdate($type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            if($this->getSide($this->getFacing())->isTransparent()){
                $this->level->useBreakOn($this);
                return Level::BLOCK_UPDATE_NORMAL;
            }
        }elseif($type === Level::BLOCK_UPDATE_SCHEDULED){
            if($this->isActivated()){
                $this->setDamage($this->getDamage() ^ 0x08);
                $this->level->setBlock($this, $this, true, false);
                $this->level->broadcastLevelSoundEvent($this->add(0.5, 0.5, 0.5), LevelSoundEventPacket::SOUND_POWER_OFF, $this->getId());
            }

            return Level::BLOCK_UPDATE_SCHEDULED;
        }
        return false;
    }

	public function canBeActivated() : bool{
		return true;
	}

    public function isActivated() : bool{
        return ($this->getDamage() & 0x08) > 0;
    }

    public function getFacing() : int{
        $side = $this->isActivated() ? $this->getDamage() ^ 0x08 : $this->getDamage();
        return $side;
    }
}
