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

use pocketmine\network\mcpe\protocol\types\WindowTypes;

/**
 * Saves all the information regarding default inventory sizes and types
 */
use function count;

class InventoryType{

	//NOTE: Do not confuse these with the network IDs.
	public const CHEST = 0;
	public const DOUBLE_CHEST = 1;
	public const PLAYER = 2;
	public const FURNACE = 3;
	public const CRAFTING = 4;
	public const WORKBENCH = 5;
	public const STONECUTTER = 6; //No using to minecraft
	public const BREWING_STAND = 7;
	public const ANVIL = 8;
	public const ENCHANT_TABLE = 9;
	public const HOPPER = 10;
	public const DROPPER = 11;
	public const ENDER_CHEST = 12;
    public const BEACON = 14;
    public const SHULKER_BOX = 15;

	public const PLAYER_FLOATING = 254;

	private static $default = [];

	private $size;
	private $title;
	private $typeId;

	/**
	 * @param $index
	 *
	 * @return InventoryType|null
	 */
	public static function get($index){
		return static::$default[$index] ?? null;
	}

	public static function init(){
		if(count(static::$default) > 0){
			return;
		}

		//TODO: move network stuff out of here
		//TODO: move inventory data to json
		static::$default = [
			static::CHEST =>           new InventoryType(27, "Chest", WindowTypes::CONTAINER),
			static::DOUBLE_CHEST =>    new InventoryType(27 + 27, "Double Chest", WindowTypes::CONTAINER),
			static::PLAYER =>          new InventoryType(36 + 4 + 1, "Player", WindowTypes::INVENTORY), //36 CONTAINER, 4 ARMOR, 1 OFFHAND
			static::CRAFTING =>        new InventoryType(5, "Crafting", WindowTypes::INVENTORY), //yes, the use of INVENTORY is intended! 4 CRAFTING slots, 1 RESULT
			static::WORKBENCH =>       new InventoryType(10, "Crafting", WindowTypes::WORKBENCH), //9 CRAFTING slots, 1 RESULT
			static::FURNACE =>         new InventoryType(3, "Furnace", WindowTypes::FURNACE), //2 INPUT, 1 OUTPUT
			static::ENCHANT_TABLE =>   new InventoryType(2, "Enchant", WindowTypes::ENCHANTMENT), //1 INPUT/OUTPUT, 1 LAPIS
			static::BREWING_STAND =>   new InventoryType(5, "Brewing", WindowTypes::BREWING_STAND), //1 INPUT, 3 POTION
			static::ANVIL =>           new InventoryType(3, "Anvil", WindowTypes::ANVIL), //2 INPUT, 1 OUTPUT
			static::HOPPER =>          new InventoryType(5, "Hopper", WindowTypes::HOPPER),
			static::DROPPER =>         new InventoryType(9, "Dropper", WindowTypes::DROPPER),
			static::ENDER_CHEST =>     new InventoryType(27, "Ender Chest", WindowTypes::CONTAINER),
			static::PLAYER_FLOATING => new InventoryType(36, "Floating", null), //Mirror all slots of main inventory (needed for large item pickups)
            static::BEACON =>          new InventoryType(0, "Beacon", WindowTypes::BEACON),
			static::SHULKER_BOX =>     new InventoryType(27, "ShulkerBox", WindowTypes::CONTAINER),
        ];
	}

	/**
	 * @param int    $defaultSize
	 * @param string $defaultTitle
	 * @param int    $typeId
	 */
	private function __construct($defaultSize, $defaultTitle, $typeId = 0){
		$this->size = $defaultSize;
		$this->title = $defaultTitle;
		$this->typeId = $typeId;
	}

	/**
	 * @return int
	 */
	public function getDefaultSize() : int{
		return $this->size;
	}

	/**
	 * @return string
	 */
	public function getDefaultTitle() : string{
		return $this->title;
	}

	/**
	 * @return int
	 */
	public function getNetworkType() : int{
		return $this->typeId;
	}
}