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

class PersonaPiece{

	/** @var string */
	protected $pieceId;
	/** @var string */
	protected $pieceType;
	/** @var string */
	protected $packId;
	/** @var bool */
	protected $isDefault;
	/** @var string */
	protected $productId;

	public function __construct(string $pieceId, string $pieceType, string $packId, bool $isDefaultPiece, string $productId){
		$this->pieceId = $pieceId;
		$this->pieceType = $pieceType;
		$this->packId = $packId;
		$this->isDefault = $isDefaultPiece;
		$this->productId = $productId;
	}

	/**
	 * @return string
	 */
	public function getPieceId() : string{
		return $this->pieceId;
	}

	/**
	 * @return string
	 */
	public function getPieceType() : string{
		return $this->pieceType;
	}

	/**
	 * @return string
	 */
	public function getPackId() : string{
		return $this->packId;
	}

	/**
	 * @return bool
	 */
	public function isDefault() : bool{
		return $this->isDefault;
	}

	/**
	 * @return string
	 */
	public function getProductId() : string{
		return $this->productId;
	}
}