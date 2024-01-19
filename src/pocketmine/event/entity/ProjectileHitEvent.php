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

use pocketmine\entity\Projectile;
use pocketmine\math\RayTraceResult;

class ProjectileHitEvent extends EntityEvent{
	public static $handlerList = null;

	/** @var RayTraceResult */
	private $rayTraceResult;

	/**
	 * @param Projectile $entity
	 */
	public function __construct(Projectile $entity, RayTraceResult $rayTraceResult){
		$this->entity = $entity;
		$this->rayTraceResult = $rayTraceResult;
	}

	/**
	 * @return Projectile
	 */
	public function getEntity(){
		return $this->entity;
	}

	/**
	 * Returns a RayTraceResult object containing information such as the exact position struck, the AABB it hit, and
	 * the face of the AABB that it hit.
	 *
	 * @return RayTraceResult
	 */
	public function getRayTraceResult() : RayTraceResult{
		return $this->rayTraceResult;
	}
}