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

namespace pocketmine\event\explosion;

use pocketmine\event\Event;
use pocketmine\level\Explosion;

abstract class ExplosionEvent extends Event{

	/** @var Explosion */
	protected $explosion;

	public function __construct(Explosion $explosion){
		$this->explosion = $explosion;
	}

	/**
	 * @return Explosion
	 */
	public function getExplosion() : Explosion{
		return $this->explosion;
	}
}