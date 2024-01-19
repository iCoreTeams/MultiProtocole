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

class GenericParticle extends Particle{

	protected $id;
	protected $data;

	public function __construct(Vector3 $pos, $id, $data = 0){
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->id = $id & 0xFFF;
		$this->data = $data;
	}

	public function encode(){
		$pk = new LevelEventPacket;
		$pk->evid = LevelEventPacket::EVENT_ADD_PARTICLE_MASK | $this->id;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->data = $this->data;

		return $pk;
	}
}
