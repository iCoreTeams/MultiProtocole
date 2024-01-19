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

namespace pocketmine\level;

/**
 * This interface allows you to listen for events related to levels. This is only used for handling level unloading for now.
 *
 * @see Level::registerLevelListener()
 * @see Level::unregisterLevelListener()
 */
interface LevelListener{

	/**
	 * This method will be called when a Level is unloaded.
	 * 
	 * @param Level $level
	 */
	public function onLevelUnloaded(Level $level);
}