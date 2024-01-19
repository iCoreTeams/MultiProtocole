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
use pocketmine\item\TieredTool;
use pocketmine\item\Tool;

class StoneBricks extends Solid{
	public const NORMAL = 0;
	public const MOSSY = 1;
	public const CRACKED = 2;
	public const CHISELED = 3;

	protected $id = self::STONE_BRICKS;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 1.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getToolHarvestLevel() : int{
		return TieredTool::TIER_WOODEN;
	}

	public function getName(){
		static $names = [
			self::NORMAL => "Stone Bricks",
			self::MOSSY => "Mossy Stone Bricks",
			self::CRACKED => "Cracked Stone Bricks",
			self::CHISELED => "Chiseled Stone Bricks",
		];
		return $names[$this->meta & 0x03];
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::STONE_BRICKS, $this->meta & 0x03, 1],
			];
		}else{
			return [];
		}
	}

}