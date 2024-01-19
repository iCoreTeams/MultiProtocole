<?php

/*
 * This file is part of BedrockProtocol.
 * Copyright (C) 2014-2022 PocketMine Team <https://github.com/pmmp/BedrockProtocol>
 *
 * BedrockProtocol is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace pocketmine\network\bedrock\protocol\types;

use pocketmine\network\bedrock\protocol\PlayerActionPacket;
use pocketmine\utils\BinaryStream;
use pocketmine\math\Vector3;

/** This is used for PlayerAuthInput packet when the flags include PERFORM_BLOCK_ACTIONS */
final class PlayerBlockActionWithBlockInfo implements PlayerBlockAction{
	public function __construct(
		private int $actionType,
		private float|int $x,
        private float|int $y,
        private float|int $z,
		private int $face
	){
		if(!self::isValidActionType($actionType)){
			throw new \InvalidArgumentException("Invalid action type for " . self::class);
		}
	}

	public function getActionType() : int{ return $this->actionType; }

	public function getBlockPosition() : Vector3{ return new Vector3($this->x, $this->y, $this->z); }

	public function getFace() : int{ return $this->face; }

	public static function read(BinaryStream $in, int $actionType) : self{
        $x = 0;
        $y = 0;
        $z = 0;
		$in->getBlockPosition($x, $y, $z);
		$face = $in->getVarInt();
		return new self($actionType, $x, $y, $z, $face);
	}

	public function write(BinaryStream $out) : void{
        $out->putBlockPosition($this->x, $this->y, $this->z);
		$out->putVarInt($this->face);
	}

	public static function isValidActionType(int $actionType) : bool{
		return match($actionType){
			PlayerActionPacket::ACTION_ABORT_BREAK,
			PlayerActionPacket::ACTION_START_BREAK,
			PlayerActionPacket::ACTION_CRACK_BREAK,
			PlayerActionPacket::ACTION_PREDICT_DESTROY_BLOCK,
			PlayerActionPacket::ACTION_CONTINUE_DESTROY_BLOCK => true,
			default => false
		};
	}
}