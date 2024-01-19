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

namespace pocketmine\event\inventory;

use pocketmine\event\Cancellable;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\Player;

class InventoryClickEvent extends InventoryEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Player */
	private $who;
	private $slot;
	/** @var Item */
	private $item;

	/**
	 * @param Inventory $inventory
	 * @param Player    $who
	 * @param int       $slot
	 * @param Item      $item
	 */
	public function __construct(Inventory $inventory, Player $who, int $slot, Item $item){
		$this->who = $who;
		$this->slot = $slot;
		$this->item = $item;
		parent::__construct($inventory);
	}

	/**
	 * @return Player
	 */
	public function getWhoClicked(): Player{
		return $this->who;
	}

	/**
	 * @return Player
	 */
	public function getPlayer(): Player{
		return $this->who;
	}

	/**
	 * @return int
	 */
	public function getSlot(): int{
		return $this->slot;
	}

	/**
	 * @return Item
	 */
	public function getItem(): Item{
		return $this->item;
	}
}