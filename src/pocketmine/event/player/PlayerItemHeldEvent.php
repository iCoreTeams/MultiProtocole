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

use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

class PlayerItemHeldEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Item */
	private $item;
	/** @var int */
	private $hotbarSlot;
	/** @var int */
	private $inventorySlot;

	public function __construct(Player $player, Item $item, int $inventorySlot, int $hotbarSlot){
		$this->player = $player;
		$this->item = $item;
		$this->inventorySlot = $inventorySlot;
		$this->hotbarSlot = $hotbarSlot;
	}

	/**
	 * Returns the hotbar slot the player is attempting to hold.
	 * @return int
	 */
	public function getSlot() : int{
		return $this->hotbarSlot;
	}

	/**
	 * @return int
	 */
	public function getInventorySlot() : int{
		return $this->inventorySlot;
	}

	public function getItem() : Item{
		return $this->item;
	}

}