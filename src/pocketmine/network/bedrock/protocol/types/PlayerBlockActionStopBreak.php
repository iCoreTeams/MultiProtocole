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

use pocketmine\utils\BinaryStream;
use pocketmine\network\bedrock\protocol\PlayerActionPacket;

final class PlayerBlockActionStopBreak implements PlayerBlockAction{

	public function getActionType() : int{
		return PlayerActionPacket::ACTION_STOP_BREAK;
	}

	public function write(BinaryStream $out) : void{
		//NOOP
	}
}