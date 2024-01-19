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

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\math\RayTraceResult;

class MovingObjectPosition{
	public const TYPE_BLOCK_COLLISION = 0;
	public const TYPE_ENTITY_COLLISION = 1;

	/** @var RayTraceResult */
	public $hitResult;

	/** @var int */
	public $typeOfHit;

	/** @var Entity|null */
	public $entityHit = null;
	/** @var Block|null */
	public $blockHit = null;

	protected function __construct(int $hitType, RayTraceResult $hitResult){
		$this->typeOfHit = $hitType;
		$this->hitResult = $hitResult;
	}

	/**
	 * @param Block          $block
	 * @param RayTraceResult $result
	 *
	 * @return MovingObjectPosition
	 */
	public static function fromBlock(Block $block, RayTraceResult $result) : MovingObjectPosition{
		$ob = new MovingObjectPosition(self::TYPE_BLOCK_COLLISION, $result);
		$ob->blockHit = $block;
		return $ob;
	}

	/**
	 * @param Entity         $entity
	 *
	 * @param RayTraceResult $result
	 *
	 * @return MovingObjectPosition
	 */
	public static function fromEntity(Entity $entity, RayTraceResult $result) : MovingObjectPosition{
		$ob = new MovingObjectPosition(self::TYPE_ENTITY_COLLISION, $result);
		$ob->entityHit = $entity;

		return $ob;
	}
}