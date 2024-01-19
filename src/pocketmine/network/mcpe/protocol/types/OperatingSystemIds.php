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

namespace pocketmine\network\mcpe\protocol\types;

/**
 * @deprecated
 */
interface OperatingSystemIds{

	public const UNKNOWN = -1;
	public const ANDROID = 1;
	public const IOS = 2;
	public const OSX = 3;
	public const FIREOS = 4;
	public const GEARVR = 5;
	public const HOLOLENS = 6;
	public const WIN10 = 7;
	public const WIN32 = 8;
	public const DEDICATED = 9;
	public const ORBIS = 10;
	public const NX = 11;

}
