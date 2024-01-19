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

namespace pocketmine\tile;


use pocketmine\level\Level;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;

class Bed extends Spawnable{

	public function __construct(Level $level, CompoundTag $nbt){
		if(!$nbt->hasTag("color", ByteTag::class)){
			$nbt->setByte("color", 14); //default to old red
		}
		parent::__construct($level, $nbt);
	}

	public function getColor() : int{
		return $this->namedtag->getByte("color");
	}

	public function setColor(int $color){
		$this->namedtag->setByte("color", $color & 0x0f);
		$this->onChanged();
	}

	public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
		$nbt->setByte("color", $this->getColor());
	}
}