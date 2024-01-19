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

use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;

class GoldenApple extends Food{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLDEN_APPLE, $meta, $count, "Golden Apple");
	}

	public function canBeConsumedBy(Entity $entity) : bool{
		return $entity instanceof Human;
	}

	public function getFoodRestore() : int{
		return 4;
	}

	public function getSaturationRestore() : float{
		return 9.6;
	}

	public function getAdditionalEffects() : array{
		return [
			Effect::getEffect(Effect::REGENERATION)->setDuration(100)->setAmplifier(1),
			Effect::getEffect(Effect::ABSORPTION)->setDuration(2400)
		];
	}
}

