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

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class WoodenSlab extends Slab{

	protected $id = self::WOODEN_SLAB;

	protected $doubleId = self::DOUBLE_WOODEN_SLAB;

	public function getHardness(){
		return 2;
	}

	public function getName(){
		static $names = [
			0 => "Oak",
			1 => "Spruce",
			2 => "Birch",
			3 => "Jungle",
			4 => "Acacia",
			5 => "Dark Oak",
			6 => "",
			7 => ""
		];
		return (($this->meta & 0x08) === 0x08 ? "Upper " : "") . $names[$this->meta & 0x07] . " Wooden Slab";
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function getDrops(Item $item){
		return [
			[$this->id, $this->meta & 0x07, 1],
		];
	}
}