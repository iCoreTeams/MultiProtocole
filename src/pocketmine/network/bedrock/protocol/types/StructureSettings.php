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

class StructureSettings{

	/** @var string */
	public $paletteName;
	/** @var bool */
	public $ignoreEntities;
	/** @var bool */
	public $ignoreBlocks;
	/** @var bool */
	public $allowNonTickingChunks;
	/** @var int */
	public $structureSizeX;
	/** @var int */
	public $structureSizeY;
	/** @var int */
	public $structureSizeZ;
	/** @var int */
	public $structureOffsetX;
	/** @var int */
	public $structureOffsetY;
	/** @var int */
	public $structureOffsetZ;
	/** @var int */
	public $lastTouchedByPlayerId;
	/** @var int */
	public $rotation;
	/** @var int */
	public $mirror;
	/** @var float */
	public $integrityValue;
	/** @var int */
	public $integritySeed;
}
