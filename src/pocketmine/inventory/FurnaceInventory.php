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

namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\tile\Furnace;

class FurnaceInventory extends ContainerInventory{


	public const SMELTING = 0;
	public const FUEL = 1;
	public const RESULT = 2;


	public function __construct(Furnace $tile){
		parent::__construct($tile, InventoryType::get(InventoryType::FURNACE));
	}

	/**
	 * @return Furnace
	 */
	public function getHolder(){
		return $this->holder;
	}

	/**
	 * @return Item
	 */
	public function getResult() : Item{
		return $this->getItem(self::RESULT);
	}

	/**
	 * @return Item
	 */
	public function getFuel() : Item{
		return $this->getItem(self::FUEL);
	}

	/**
	 * @return Item
	 */
	public function getSmelting() : Item{
		return $this->getItem(self::SMELTING);
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setResult(Item $item) : bool{
		return $this->setItem(self::RESULT, $item);
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setFuel(Item $item) : bool{
		return $this->setItem(self::FUEL, $item);
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setSmelting(Item $item) : bool{
		return $this->setItem(self::SMELTING, $item);
	}

	public function onSlotChange($index, $before, $send){
		parent::onSlotChange($index, $before, $send);

		$this->getHolder()->scheduleUpdate();
	}
}
