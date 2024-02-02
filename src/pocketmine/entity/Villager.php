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

namespace pocketmine\entity;

use pocketmine\nbt\tag\IntTag;

class Villager extends Creature implements NPC, Ageable{
	public const PROFESSION_FARMER = 0;
	public const PROFESSION_LIBRARIAN = 1;
	public const PROFESSION_PRIEST = 2;
	public const PROFESSION_BLACKSMITH = 3;
	public const PROFESSION_BUTCHER = 4;
	public const PROFESSION_GENERIC = 5;

	public const NETWORK_ID = self::VILLAGER;

	public float $width = 0.6;
	public float $height = 1.8;

	public function getName(){
		return "Villager";
	}

	protected function initEntity(){
		parent::initEntity();
		if(!$this->namedtag->hasTag("Profession", IntTag::class)){
			$this->setProfession(self::PROFESSION_GENERIC);
		}
	}

	/**
	 * Sets the villager profession
	 *
	 * @param $profession
	 */
	public function setProfession($profession){
		$this->namedtag->setInt("Profession", $profession);
	}

	public function getProfession(){
		return $this->namedtag->getInt("Profession");
	}

	public function isBaby(){
		return $this->getDataFlag(self::DATA_FLAGS, self::DATA_FLAG_BABY);
	}
}
