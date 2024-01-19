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

namespace pocketmine\network\bedrock\protocol\types;

class EnchantmentOption{

	/** @var int */
	public $cost;
	/** @var ItemEnchantments */
	public $enchantments;
	/** @var string */
	public $name;
	/** @var int */
	public $recipeNetworkId;

	public function __construct(int $cost = -1, ?ItemEnchantments $enchantments = null, string $name = "", int $recipeNetworkId = -1){
		$this->cost = $cost;
		$this->enchantments = $enchantments;
		$this->name = $name;
		$this->recipeNetworkId = $recipeNetworkId;
	}
}