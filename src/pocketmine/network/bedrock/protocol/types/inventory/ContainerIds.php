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

namespace pocketmine\network\bedrock\protocol\types\inventory;

interface ContainerIds{

	public const NONE = -1;
	public const INVENTORY = 0;
	public const FIRST = 1;
	public const LAST = 100;
	public const OFFHAND = 119;
	public const ARMOR = 120;
	public const HOTBAR = 122;
	public const FIXED_INVENTORY = 123;
	public const UI = 124;
	public const CRAFTER = 62;

}
