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

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

/**
 * Called when an Entity, excluding players, changes a block directly
 */
class EntityBlockChangeEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	private $from;
	private $to;

	public function __construct(Entity $entity, Block $from, Block $to){
		$this->entity = $entity;
		$this->from = $from;
		$this->to = $to;
	}

	/**
	 * @return Block
	 */
	public function getBlock(){
		return $this->from;
	}

	/**
	 * @return Block
	 */
	public function getTo(){
		return $this->to;
	}

}