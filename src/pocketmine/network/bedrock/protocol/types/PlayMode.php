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

/**
 * Enum used by PlayerAuthInputPacket. Most of these names don't make any sense, but that isn't surprising.
 */
final class PlayMode{

	public const NORMAL = 0;
	public const TEASER = 1;
	public const SCREEN = 2;
	public const VIEWER = 3;
	public const VR = 4;
	public const PLACEMENT = 5;
	public const LIVING_ROOM = 6;
	public const EXIT_LEVEL = 7;
	public const EXIT_LEVEL_LIVING_ROOM = 8;

	private function __construct(){
		// oof
	}
}