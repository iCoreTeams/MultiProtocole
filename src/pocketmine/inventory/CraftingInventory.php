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

/**
 * Manages crafting operations
 * This class includes future methods for shaped crafting
 *
 * TODO: add small matrix inventory
 */
class CraftingInventory extends BaseInventory{

	/** @var Inventory */
	private $resultInventory;

	/**
	 * @param InventoryHolder $holder
	 * @param Inventory       $resultInventory
	 * @param InventoryType   $inventoryType
	 *
	 * @throws \Exception
	 */
	public function __construct(InventoryHolder $holder, Inventory $resultInventory, InventoryType $inventoryType){
		if($inventoryType->getDefaultTitle() !== "Crafting"){
			throw new \InvalidStateException("Invalid Inventory type, expected CRAFTING or WORKBENCH");
		}
		$this->resultInventory = $resultInventory;
		parent::__construct($holder, $inventoryType);
	}

	/**
	 * @return Inventory
	 */
	public function getResultInventory(){
		return $this->resultInventory;
	}

	public function getSize() : int{
		return $this->getResultInventory()->getSize() + parent::getSize();
	}
}