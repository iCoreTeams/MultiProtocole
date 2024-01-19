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

final class ActorMapping{

	private function __construct(){
		//NOOP
	}

	/** @var int[] */
	private static $stringToLegacyIdMap = [];
	/** @var string[] */
	private static $legacyToStringIdMap = [];

	/** @var string */
	private static $encodedActorIdentifiers;

	public static function init() : void{
		self::$stringToLegacyIdMap = json_decode(file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/bedrock/actor_id_map.json"), true);
		self::$stringToLegacyIdMap[":"] = 1; //empty id

		self::$legacyToStringIdMap = array_flip(self::$stringToLegacyIdMap);
		self::$stringToLegacyIdMap[""] = 1; //another empty id

		self::$encodedActorIdentifiers = file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/bedrock/actor_identifiers.nbt");
	}

	/**
	 * @param int $entityId
	 *
	 * @return string
	 */
	public static function getStringIdFromLegacyId(int $entityId) : string{
		return self::$legacyToStringIdMap[$entityId] ?? ":";
	}

	/**
	 * @param string $stringId
	 *
	 * @return int
	 */
	public static function getLegacyIdFromStringId(string $stringId) : int{
		return self::$stringToLegacyIdMap[$stringId] ?? -1;
	}

	/**
	 * @return string
	 */
	public static function getEncodedActorIdentifiers() : string{
		return self::$encodedActorIdentifiers;
	}
}