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

class ScorePacketEntry{
	public const TYPE_PLAYER = 1;
	public const TYPE_ACTOR = 2;
	public const TYPE_FAKE_PLAYER = 3;

	/** @var int */
	public $scoreboardId;
	/** @var string */
	public $objectiveName;
	/** @var int */
	public $score;

	/** @var int */
	public $type;

	/** @var int|null (if type entity or player) */
	public $actorUniqueId;
	/** @var string|null (if type fake player) */
	public $customName;
}
