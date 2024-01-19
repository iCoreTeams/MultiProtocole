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

namespace pocketmine\network\bedrock\protocol\types\inventory;

use pocketmine\item\Item;

class ItemInstance{

	/** @var int */
	public $stackNetworkId;
	/** @var Item */
	public $stack;

	public function __construct(?int $stackNetworkId = null, ?Item $stack = null){
		$this->stackNetworkId = $stackNetworkId;
		$this->stack = $stack;
	}

	public static function legacy(Item $itemStack) : self{
		return new self($itemStack->isNull() ? 0 : 1, $itemStack);
	}
}