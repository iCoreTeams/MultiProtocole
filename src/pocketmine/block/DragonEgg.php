<?php

/*
 *
 *  _____            _               _____           
 * / ____|          (_)             |  __ \          
 *| |  __  ___ _ __  _ ___ _   _ ___| |__) | __ ___  
 *| | |_ |/ _ \ '_ \| / __| | | / __|  ___/ '__/ _ \ 
 *| |__| |  __/ | | | \__ \ |_| \__ \ |   | | | (_) |
 * \_____|\___|_| |_|_|___/\__, |___/_|   |_|  \___/ 
 *                         __/ |                    
 *                        |___/                     
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author GenisysPro
 * @link https://github.com/GenisysPro/GenisysPro
 *
 *
*/

namespace pocketmine\block;

use pocketmine\event\block\BlockDragonEggTeleportEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Player;

class DragonEgg extends Fallable
{

	protected $id = self::DRAGON_EGG;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Dragon Egg";
	}

	public function getHardness(){
		return 3;
	}

	public function getResistance(): float
    {
		return 45;
	}

    public function getLightLevel():int {
        return 1;
    }

    public function isTransparent():bool {
        return true;
    }

    public function onActivate(Item $item, Player $player = null){
        if ($player != null) {
            if ($player->isCreative()) {
                return;
            }
            $this->onUpdate(Level::BLOCK_UPDATE_TOUCH);
        }
    }

    public function onUpdate($type): bool
    {
        if($type === Level::BLOCK_UPDATE_TOUCH){
            $this->randomTeleport();
        }
        return parent::onUpdate($type);
    }

    public function randomTeleport():void
    {
        for ($i = 0; $i < 1000; ++$i) {
            $to = $this->level->getBlock($this->add(mt_rand(-16, 16), mt_rand(0, 4), mt_rand(-16, 16)));
            if ($to instanceof Air) {
                $ev = new BlockDragonEggTeleportEvent($this, $to);
                $ev->call();
                if($ev->isCancelled()){
                    return;
                }
                $to = $ev->getTo();
                $diffX = $this->getFloorX() - $to->getFloorX();
                $diffY = $this->getFloorY() - $to->getFloorY();
                $diffZ = $this->getFloorZ() - $to->getFloorZ();
                $pk = new LevelEventPacket();
                $pk->evid = LevelEventPacket::EVENT_PARTICLE_DRAGON_EGG_TELEPORT;
                $pk->data = (((((abs($diffX) << 16) | (abs($diffY) << 8)) | abs($diffZ)) | (($diffX < 0 ? 1 : 0) << 24)) | (($diffY < 0 ? 1 : 0) << 25)) | (($diffZ < 0 ? 1 : 0) << 26);
                $pk->x = $this->getFloorX();
                $pk->y = $this->getFloorY();
                $pk->z = $this->getFloorZ();
                $this->level->addChunkPacket($this->getFloorX() >> 4, $this->getFloorZ() >> 4, $pk);
                $this->level->setBlock($this, Block::get(0), true);
                $this->level->setBlock($to, $this, true);
                return;
            }
        }
    }

	public function isBreakable(Item $item): bool{
		return false;
	}
}
