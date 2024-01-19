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
use pocketmine\level\Level;

class EntityLevelChangeEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	private $originLevel;
	private $targetLevel;

	public function __construct(Entity $entity, Level $originLevel, Level $targetLevel){
		$this->entity = $entity;
		$this->originLevel = $originLevel;
		$this->targetLevel = $targetLevel;
	}

	public function getOrigin(){
		return $this->originLevel;
	}

	public function getTarget(){
		return $this->targetLevel;
	}
}