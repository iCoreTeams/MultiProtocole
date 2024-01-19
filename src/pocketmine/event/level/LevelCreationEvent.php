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

namespace pocketmine\event\level;

use pocketmine\event\Event;

/**
 * Called when a Level is loaded
 */
class LevelCreationEvent extends Event{
	public static $handlerList = null;

    public function __construct(
        private readonly string $levelName,
        private string $levelClass
    ) {}

    public function getLevelName() : string{
        return $this->levelName;
    }

    public function setLevelClass(string $class) : void{
        $this->levelClass = $class;
    }

    public function getLevelClass() : string{
        return $this->levelClass;
    }
}