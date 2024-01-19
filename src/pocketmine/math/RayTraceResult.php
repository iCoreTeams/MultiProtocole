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

namespace pocketmine\math;

/**
 * Class representing a ray trace collision with an AxisAlignedBB
 */
class RayTraceResult{

	/**
	 * @var AxisAlignedBB
	 */
	public $bb;
	/**
	 * @var int
	 */
	public $hitFace;
	/**
	 * @var Vector3
	 */
	public $hitVector;
	public $blockX;
	public $blockY;
	public $blockZ;

	/**
	 * @param AxisAlignedBB $bb
	 * @param int           $hitFace one of the Vector3::SIDE_* constants
	 * @param Vector3       $hitVector
	 */
	public function __construct(AxisAlignedBB $bb, int $hitFace, Vector3 $hitVector){
		$this->bb = $bb;
		$this->hitFace = $hitFace;
		$this->hitVector = $hitVector;
	}

	/**
	 * @return AxisAlignedBB
	 */
	public function getBoundingBox() : AxisAlignedBB{
		return $this->bb;
	}

	/**
	 * @return int
	 */
	public function getHitFace() : int{
		return $this->hitFace;
	}

	/**
	 * @return Vector3
	 */
	public function getHitVector() : Vector3{
		return $this->hitVector;
	}
}