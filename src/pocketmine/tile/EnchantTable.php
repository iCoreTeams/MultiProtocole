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

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

class EnchantTable extends Spawnable implements Nameable{


	public function getName() : string{
		return $this->hasName() ? $this->namedtag->getString("CustomName") : "Enchanting Table";
	}

	public function hasName() : bool{
		return $this->namedtag->hasTag("CustomName", StringTag::class);
	}

	public function setName(string $str){
		if($str === ""){
			$this->namedtag->removeTag("CustomName");
			return;
		}

		$this->namedtag->setString("CustomName", $str);
	}

	public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
		if($this->hasName()){
			$nbt->setString("CustomName", $this->namedtag->getString("CustomName"));
		}
	}
}
