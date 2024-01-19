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

class Skull extends Spawnable{
	public const TYPE_SKELETON = 0;
	public const TYPE_WITHER = 1;
	public const TYPE_ZOMBIE = 2;
	public const TYPE_HUMAN = 3;
	public const TYPE_CREEPER = 4;
	public const TYPE_DRAGON = 5;

	public function __construct(Level $level, CompoundTag $nbt){
		if(!$nbt->hasTag("SkullType", ByteTag::class)){
			$nbt->setByte("SkullType", 0);
		}
		if(!$nbt->hasTag("Rot", ByteTag::class)){
			$nbt->setByte("Rot", 0);
		}
		parent::__construct($level, $nbt);
	}

	public function setType(int $type){
		$this->namedtag->setByte("SkullType", $type);
		$this->onChanged();
	}

	public function getType() : int{
		return $this->namedtag->getByte("SkullType");
	}

	public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
		$nbt->setByte("SkullType", $this->namedtag->getByte("SkullType"));
		$nbt->setByte("Rot", $this->namedtag->getByte("Rot"));
	}
}