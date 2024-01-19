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

namespace pocketmine\event\player;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

/**
 * Called when a player interacts an entity.
 */
class PlayerEntityInteractEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Entity */
	protected $entity;
	/** @var Item */
	protected $item;

	public function __construct(Player $player, Entity $entity, Item $item){
		$this->player = $player;
		$this->entity = $entity;
		$this->item = $item;
	}

	/**
	 * @return Entity
	 */
	public function getEntity() : Entity{
		return $this->entity;
	}

	/**
	 * @return Item
	 */
	public function getItem() : Item{
		return $this->item;
	}
}
