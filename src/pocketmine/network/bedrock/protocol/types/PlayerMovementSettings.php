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

use pocketmine\network\mcpe\NetworkBinaryStream;

final class PlayerMovementSettings{
	/** @var int */
	private $movementType;
	/** @var int */
	private $rewindHistorySize;
	/** @var bool */
	private $serverAuthoritativeBlockBreaking;

	public function __construct(int $movementType, int $rewindHistorySize, bool $serverAuthoritativeBlockBreaking){
		$this->movementType = $movementType;
		$this->rewindHistorySize = $rewindHistorySize;
		//do not ask me what the F this is doing here
		$this->serverAuthoritativeBlockBreaking = $serverAuthoritativeBlockBreaking;
	}

	public function getMovementType() : int{
		return $this->movementType;
	}

	public function getRewindHistorySize() : int{
		return $this->rewindHistorySize;
	}

	public function isServerAuthoritativeBlockBreaking() : bool{
		return $this->serverAuthoritativeBlockBreaking;
	}

	public static function read(NetworkBinaryStream $in) : self{
		$movementType = $in->getVarInt();
		$rewindHistorySize = $in->getVarInt();
		$serverAuthBlockBreaking = $in->getBool();
		return new self($movementType, $rewindHistorySize, $serverAuthBlockBreaking);
	}

	public function write(NetworkBinaryStream $out) : void{
		$out->putVarInt($this->movementType);
		$out->putVarInt($this->rewindHistorySize);
		$out->putBool($this->serverAuthoritativeBlockBreaking);
	}
}