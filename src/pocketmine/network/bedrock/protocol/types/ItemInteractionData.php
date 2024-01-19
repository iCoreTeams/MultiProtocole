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

use pocketmine\network\bedrock\protocol\types\inventory\LegacySetItemSlot;
use pocketmine\network\bedrock\protocol\DataPacket;

final class ItemInteractionData{
	public function __construct(
        public LegacySetItemSlot $legacySetItemSlot
	){}

	public static function read(DataPacket $in) : self{
        $legacySetItemSlot = $in->getLegacySetItemSlot();
		return new ItemInteractionData($legacySetItemSlot);
	}

	public function write(DataPacket $out) : void{
		$out->putLegacySetItemSlot($this->legacySetItemSlot);
	}
}