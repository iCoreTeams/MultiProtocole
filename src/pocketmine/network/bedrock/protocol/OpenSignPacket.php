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

namespace pocketmine\network\bedrock\protocol;

use pocketmine\math\Vector3;
use pocketmine\network\NetworkSession;

/**
 * Sent by the server to open the sign GUI for a sign.
 */
class OpenSignPacket extends DataPacket{
    public const NETWORK_ID = ProtocolInfo::OPEN_SIGN_PACKET;

    public Vector3 $blockPosition;
    public bool $front;

    public function decodePayload() : void{
        $this->blockPosition = $this->getVector3();
        $this->front = $this->getBool();
    }

    public function encodePayload() : void{
        $this->putVector3($this->blockPosition);
        $this->putBool($this->front);
    }

    public function handle(NetworkSession $session) : bool{
        return $session->handleOpenSign($this);
    }
}