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

namespace pocketmine\plugin;


abstract class PluginLoadOrder{
	/*
	 * The plugin will be loaded before the other plugins
	 */
	public const PRESTARTUP = -1;

	/*
	 * The plugin will be loaded at startup
	 */
	public const STARTUP = 0;

	/*
	 * The plugin will be loaded after the first world has been loaded/created.
	 */
	public const POSTWORLD = 1;
}