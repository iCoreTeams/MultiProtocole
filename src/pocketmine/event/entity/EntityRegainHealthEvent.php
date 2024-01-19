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

class EntityRegainHealthEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	public const CAUSE_REGEN = 0;
	public const CAUSE_EATING = 1;
	public const CAUSE_MAGIC = 2;
	public const CAUSE_CUSTOM = 3;
	public const CAUSE_SATURATION = 4;

	private $amount;
	private $reason;


	/**
	 * @param Entity $entity
	 * @param float  $amount
	 * @param int    $regainReason
	 */
	public function __construct(Entity $entity, $amount, $regainReason){
		$this->entity = $entity;
		$this->amount = $amount;
		$this->reason = (int) $regainReason;
	}

	/**
	 * @return float
	 */
	public function getAmount(){
		return $this->amount;
	}

	/**
	 * @param float $amount
	 */
	public function setAmount($amount){
		$this->amount = $amount;
	}

	public function getRegainReason(){
		return $this->reason;
	}

}