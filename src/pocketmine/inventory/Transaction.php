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

use pocketmine\Player;
use pocketmine\item\Item;

interface Transaction{

	//Transaction type constants
	public const TYPE_NORMAL = 0;
	public const TYPE_SWAP = 1;
	public const TYPE_HOTBAR = 2; //swap, but with hotbar resend
	public const TYPE_DROP_ITEM = 3;

	/**
	 * @return Inventory
	 */
	public function getInventory();

	/**
	 * @return int
	 */
	public function getSlot() : int;

	/**
	 * @return Item
	 */
	public function getTargetItem() : Item;

	/**
	 * @return float
	 */
	public function getCreationTime() : float;

	/**
	 * @param Player $source
	 * @return bool
	 */
	public function execute(Player $source): bool;

}