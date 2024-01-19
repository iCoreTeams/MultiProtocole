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

namespace pocketmine\network\bedrock\palette;

use function array_flip;
use function count;
use function file_get_contents;
use function json_decode;

final class BiomePalette{

	private function __construct(){
		//NOOP
	}

	/** @var int[] */
	private static $stringToLegacyIdMap = [];
	/** @var string[] */
	private static $legacyToStringIdMap = [];

	public static function init() : void{
		self::$stringToLegacyIdMap = json_decode(file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/bedrock/biome_id_map.json"), true);
		self::$legacyToStringIdMap = array_flip(self::$stringToLegacyIdMap);
	}

	public static function lazyInit() : void{
		if(count(self::$stringToLegacyIdMap) === 0){
			self::init();
		}
	}

	/**
	 * @param int $legacyId
	 *
	 * @return string|null
	 */
	public static function getStringIdFromLegacyId(int $legacyId) : ?string{
		return self::$legacyToStringIdMap[$legacyId] ?? null;
	}

	/**
	 * @param string $stringId
	 *
	 * @return int
	 */
	public static function getLegacyIdFromStringId(string $stringId) : ?int{
		return self::$stringToLegacyIdMap[$stringId] ?? null;
	}
}