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

use pocketmine\network\bedrock\protocol\types\skin\Skin;
use pocketmine\utils\UUID;

class PlayerListEntry{

	/** @var UUID */
	public $uuid;
	/** @var int */
	public $actorUniqueId;
	/** @var string */
	public $username;
	/** @var string */
	public $xboxUserId;
	/** @var string */
	public $platformChatId = "";
	/** @var int */
	public $buildPlatform = -1;
	/** @var Skin */
	public $skin;
	/** @var bool */
	public $isTeacher = false;
	/** @var bool */
	public $isHost = false;

	public static function createRemovalEntry(UUID $uuid) : PlayerListEntry{
		$entry = new PlayerListEntry();
		$entry->uuid = $uuid;

		return $entry;
	}

	public static function createAdditionEntry(UUID $uuid, int $actorUniqueId, string $username, Skin $skin, string $xboxUserId = "", string $platformChatId = "", int $buildPlatform = OS::UNKNOWN, bool $isTeacher = false, bool $isHost = false) : PlayerListEntry{
		$entry = new PlayerListEntry();
		$entry->uuid = $uuid;
		$entry->actorUniqueId = $actorUniqueId;
		$entry->username = $username;
		$entry->xboxUserId = $xboxUserId;
		$entry->platformChatId = $platformChatId;
		$entry->buildPlatform = $buildPlatform;
		$entry->skin = $skin;
		$entry->isTeacher = $isTeacher;
		$entry->isHost = $isHost;

		return $entry;
	}
}
