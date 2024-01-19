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

class CommandParameter{
	public const FLAG_FORCE_COLLAPSE_ENUM = 0x1;
	public const FLAG_HAS_ENUM_CONSTRAINT = 0x2;

	/** @var string */
	public $paramName;
	/** @var int */
	public $paramType;
	/** @var bool */
	public $isOptional;
	/** @var CommandEnum|null */
	public $enum;
	/** @var string|null */
	public $postfix;
}
