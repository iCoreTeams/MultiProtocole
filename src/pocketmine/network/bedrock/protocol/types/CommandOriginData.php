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

use pocketmine\utils\UUID;

class CommandOriginData{
	public const ORIGIN_PLAYER = 0;
	public const ORIGIN_BLOCK = 1;
	public const ORIGIN_MINECART_BLOCK = 2;
	public const ORIGIN_DEV_CONSOLE = 3;
	public const ORIGIN_TEST = 4;
	public const ORIGIN_AUTOMATION_PLAYER = 5;
	public const ORIGIN_CLIENT_AUTOMATION = 6;
	public const ORIGIN_DEDICATED_SERVER = 7;
	public const ORIGIN_ACTOR = 8;
	public const ORIGIN_VIRTUAL = 9;
	public const ORIGIN_GAME_ARGUMENT = 10;
	public const ORIGIN_ACTOR_SERVER = 11; //???

	/** @var int */
	public $type;
	/** @var UUID */
	public $uuid;

	/** @var string */
	public $requestId;

	/** @var int */
	public $varlong1;
}
