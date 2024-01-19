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

final class OS{

	public const ANDROID = 1;
	public const IOS = 2;
	public const MACOS = 3;
	public const FIRE_OS = 4;
	public const GEAR_VR = 5;
	public const HOLOLENS = 6;
	public const WINDOWS_10 = 7;
	public const WINDOWS_MOBILE = 8;
	public const DEDICATED = 9;
	public const TVOS = 10;

	public const UNKNOWN = -1;

	private function __construct(){
		// oof
	}
}
