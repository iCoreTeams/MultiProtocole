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

class DoubleStoneSlab2 extends Solid{

	protected $id = self::DOUBLE_STONE_SLAB2;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 2;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		static $names = [
			StoneSlab2::RED_SANDSTONE => "Red Sandstone",
			StoneSlab2::PURPUR => "Purpur",
			StoneSlab2::PRISMARINE => "Prismarine",
			StoneSlab2::DARK_PRISMARINE => "Dark Prismarine",
			StoneSlab2::PRISMARINE_BRICKS => "Prismarine Bricks",
			StoneSlab2::MOSSY_COBBLESTONE => "Mossy Cobblestone",
			StoneSlab2::SMOOTH_SANDSTONE => "Smooth Sandstone",
			StoneSlab2::RED_NETHER_BRICK => "Red Nether Brick",
		];
		return "Double " . $names[$this->meta & 0x07] . " Slab";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::STONE_SLAB2, $this->meta & 0x07, 2],
			];
		}else{
			return [];
		}
	}

	public function getPickedItem() : Item{
		return Item::get(Item::STONE_SLAB2, $this->meta & 0x07);
	}
}