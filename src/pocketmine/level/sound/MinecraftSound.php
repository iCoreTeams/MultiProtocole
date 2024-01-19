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

namespace pocketmine\level\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;

class MinecraftSound extends Sound {

	protected $soundName = "";
	protected $volume = 1;
	protected $pitch = 1;

	/**
	 * MinecraftSound constructor.
	 *
	 * @param Vector3 $pos
	 * @param string  $soundName
	 * @param float   $colume
	 * @param float   $pitch
	 */
	public function __construct(Vector3 $pos, string $soundName, float $volume = 1, float $pitch = 1){
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->soundName = $soundName;
		$this->volume = $volume;
		$this->pitch = $pitch;
	}

	public function encode(){
		$pk = new PlaySoundPacket();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->soundName = $this->soundName;
		$pk->volume = $this->volume;
		$pk->pitch = $this->pitch;

		return $pk;
	}

}
