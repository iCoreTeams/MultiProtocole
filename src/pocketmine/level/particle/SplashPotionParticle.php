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

namespace pocketmine\level\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class SplashPotionParticle extends ColoredParticle{

	public function __construct(Vector3 $pos, int $r = 0, int $g = 0, int $b = 0, int $a = 255){
		parent::__construct($pos, LevelEventPacket::EVENT_PARTICLE_SPLASH, $r, $g, $b, $a);
	}

	/**
	 * @return LevelEventPacket
	 */
	public function encode(){
		$pk = new LevelEventPacket();
		$pk->evid = LevelEventPacket::EVENT_PARTICLE_SPLASH;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->data = $this->data;

		return $pk;
	}
}