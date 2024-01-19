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

namespace pocketmine\network\bedrock\protocol\types\skin;

use pocketmine\network\bedrock\protocol\types\skin\SerializedSkinImage;

class SkinAnimation{
	public const TYPE_FACE = 1;
	public const TYPE_BODY_32x32 = 2;
	public const TYPE_BODY_64x64 = 3;

	public const EXPRESSION_LINEAR = 0; //???
	public const EXPRESSION_BLINKING = 1;

	/** @var SerializedSkinImage */
	private $image;
	/** @var int */
	private $type; // TODO
	/** @var float */
	private $frames;
	/** @var int */
	private $expressionType;

	public function __construct(SerializedSkinImage $image, int $type, float $frames, int $expressionType){
		$this->image = $image;
		$this->type = $type;
		$this->frames = $frames;
		$this->expressionType = $expressionType;
	}

	/**
	 * @return SerializedSkinImage
	 */
	public function getImage() : SerializedSkinImage{
		return $this->image;
	}

	/**
	 * @return int
	 */
	public function getType() : int{
		return $this->type;
	}

	/**
	 * @return float
	 */
	public function getFrames() : float{
		return $this->frames;
	}

	/**
	 * @return int
	 */
	public function getExpressionType() : int{
		return $this->expressionType;
	}
}