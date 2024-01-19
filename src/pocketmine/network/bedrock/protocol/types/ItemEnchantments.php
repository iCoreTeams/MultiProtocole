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

class ItemEnchantments{

	public const SLOT_NONE = 0;
	public const SLOT_ALL = 0xffff;
	public const SLOT_ARMOR = self::SLOT_HELMET | self::SLOT_CHESTPLATE | self::SLOT_LEGGINGS | self::SLOT_BOOTS;
	public const SLOT_HELMET = 0x1;
	public const SLOT_CHESTPLATE = 0x2;
	public const SLOT_LEGGINGS = 0x4;
	public const SLOT_BOOTS = 0x8;
	public const SLOT_SWORD = 0x10;
	public const SLOT_BOW = 0x20;
	public const SLOT_TOOL_OTHER = self::SLOT_HOE | self::SLOT_SHEARS | self::SLOT_FLINT_AND_STEEL;
	public const SLOT_HOE = 0x40;
	public const SLOT_SHEARS = 0x80;
	public const SLOT_FLINT_AND_STEEL = 0x100;
	public const SLOT_DIG = self::SLOT_AXE | self::SLOT_PICKAXE | self::SLOT_SHOVEL;
	public const SLOT_AXE = 0x200;
	public const SLOT_PICKAXE = 0x400;
	public const SLOT_SHOVEL = 0x800;
	public const SLOT_FISHING_ROD = 0x1000;
	public const SLOT_CARROT_ON_A_STICK = 0x2000;
	public const SLOT_ELYTRA = 0x4000;
	public const SLOT_TRIDENT = 0x8000;

	/** @var int */
	public $slot;
	/** @var EnchantmentInstance[][] */
	public $enchantments;

	public function __construct(int $slot = -1, array $enchantments = []){
		$this->slot = $slot;
		$this->enchantments = $enchantments;
	}
}