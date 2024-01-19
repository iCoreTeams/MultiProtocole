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

namespace pocketmine\item\enchantment;


class EnchantmentEntry{

	/** @var Enchantment[] */
	private $enchantments;
	private $cost;
	private $randomName;

	/**
	 * @param Enchantment[] $enchantments
	 * @param number        $cost
	 * @param string        $randomName
	 */
	public function __construct(array $enchantments, $cost, $randomName){
		$this->enchantments = $enchantments;
		$this->cost = (int) $cost;
		$this->randomName = $randomName;
	}

	public function getEnchantments(){
		return $this->enchantments;
	}

	public function getCost(){
		return $this->cost;
	}

	public function getRandomName(){
		return $this->randomName;
	}

}