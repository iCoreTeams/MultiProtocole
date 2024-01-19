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

use pocketmine\level\Position;

class FakeBlockMenu extends Position implements InventoryHolder{

	private $inventory;

	public function __construct(Inventory $inventory, Position $pos){
		$this->inventory = $inventory;
		parent::__construct($pos->x, $pos->y, $pos->z, $pos->level);
	}

	public function getInventory(){
		return $this->inventory;
	}
}