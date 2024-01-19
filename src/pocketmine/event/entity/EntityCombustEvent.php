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

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

class EntityCombustEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	protected $duration;

	/**
	 * @param Entity $combustee
	 * @param int    $duration
	 */
	public function __construct(Entity $combustee, $duration){
		$this->entity = $combustee;
		$this->duration = $duration;
	}

	public function getDuration(){
		return $this->duration;
	}

	public function setDuration($duration){
		$this->duration = (int) $duration;
	}

}