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

use pocketmine\nbt\tag\CompoundTag;

class SplashPotion extends ProjectileItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SPLASH_POTION, $meta, $count, $this->getNameByMeta($meta));
	}

	public function getNameByMeta(int $meta) : string{
		return "Splash " . Potion::getNameByMeta($meta);
	}

	public function getMaxStackSize(){
		return 1;
	}

	public function getProjectileEntityType() : string{
		return "SplashPotion";
	}

	public function getThrowForce() : float{
		return 1.1;
	}

	protected function addExtraTags(CompoundTag $tag) : void{
		$tag->setShort("PotionId", $this->meta);
	}
}