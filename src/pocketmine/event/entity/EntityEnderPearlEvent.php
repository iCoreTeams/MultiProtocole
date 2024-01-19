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

use pocketmine\entity\EnderPearl;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\math\Vector3;

class EntityEnderPearlEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	/** @var EnderPearl */
	private $projectile;
	/** @var Vector3 */
	private $to;

	public function __construct(Entity $entity, EnderPearl $projectile, Vector3 $to){
		$this->entity = $entity;
		$this->projectile = $projectile;
	}

	/**
	 * @return EnderPearl
	 */
	public function getEnderPearl() : EnderPearl{
		return $this->projectile;
	}

	/**
	 * @return Vector3
	 */
	public function getTo() : Vector3{
		return $this->to;
	}
}