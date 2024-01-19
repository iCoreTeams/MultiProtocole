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

class StoneSlab2 extends StoneSlab{
	public const RED_SANDSTONE = 0;
	public const PURPUR = 1;
	public const PRISMARINE = 2;
	public const DARK_PRISMARINE = 3;
	public const PRISMARINE_BRICKS = 4;
	public const MOSSY_COBBLESTONE = 5;
	public const SMOOTH_SANDSTONE = 6;
	public const RED_NETHER_BRICK = 7;

	protected $id = self::STONE_SLAB2;

	protected $doubleId = self::DOUBLE_STONE_SLAB2;

	public function getName(){
		static $names = [
			self::RED_SANDSTONE => "Red Sandstone",
			self::PURPUR => "Purpur",
			self::PRISMARINE => "Prismarine",
			self::DARK_PRISMARINE => "Dark Prismarine",
			self::PRISMARINE_BRICKS => "Prismarine Bricks",
			self::MOSSY_COBBLESTONE => "Mossy Cobblestone",
			self::SMOOTH_SANDSTONE => "Smooth Sandstone",
			self::RED_NETHER_BRICK => "Red Nether Brick",
		];
		return (($this->meta & 0x08) > 0 ? "Upper " : "") . $names[$this->meta & 0x07] . " Slab";
	}
}