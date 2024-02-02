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
use pocketmine\entity\Living;
use pocketmine\entity\projectile\Projectile;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use function count;

class EntityShootBowEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Item */
	private $bow;
	/** @var Projectile */
	private $projectile;
	/** @var float */
	private $force;

	/**
	 * @param Living     $shooter
	 * @param Item       $bow
	 * @param Projectile $projectile
	 * @param float      $force
	 */
	public function __construct(Living $shooter, Item $bow, Projectile $projectile, $force){
		$this->entity = $shooter;
		$this->bow = $bow;
		$this->projectile = $projectile;
		$this->force = $force;
	}

	/**
	 * @return Living
	 */
	public function getEntity(){
		return $this->entity;
	}

	/**
	 * @return Item
	 */
	public function getBow(){
		return $this->bow;
	}

	/**
	 * @return Projectile
	 */
	public function getProjectile(){
		return $this->projectile;
	}

	/**
	 * @param Entity $projectile
	 */
	public function setProjectile(Entity $projectile){
		if($projectile !== $this->projectile){
			if(count($this->projectile->getViewers()) === 0){
				$this->projectile->kill();
				$this->projectile->close();
			}
			$this->projectile = $projectile;
		}
	}

	/**
	 * @return float
	 */
	public function getForce(){
		return $this->force;
	}

	/**
	 * @param float $force
	 */
	public function setForce($force){
		$this->force = $force;
	}


}