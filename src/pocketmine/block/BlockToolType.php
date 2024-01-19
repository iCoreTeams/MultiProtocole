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

namespace pocketmine\block;

/**
 * Types of tools that can be used to break blocks
 * Blocks may allow multiple tool types by combining these bitflags
 */
interface BlockToolType{

    public const TYPE_NONE = 0;
    public const TYPE_SWORD = 1 << 0;
    public const TYPE_SHOVEL = 1 << 1;
    public const TYPE_PICKAXE = 1 << 2;
    public const TYPE_AXE = 1 << 3;
    public const TYPE_SHEARS = 1 << 4;
    public const TYPE_HOE = 1 << 5;

}
