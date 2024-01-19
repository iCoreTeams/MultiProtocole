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

namespace pocketmine\inventory;

/**
 * The in-between inventory where items involved in transactions are stored temporarily
 */
class FloatingInventory extends BaseInventory{

	/**
	 * @param InventoryHolder $holder
	 * @param InventoryType   $inventoryType
	 */
	public function __construct(InventoryHolder $holder){
		parent::__construct($holder, InventoryType::get(InventoryType::PLAYER_FLOATING));
	}
}