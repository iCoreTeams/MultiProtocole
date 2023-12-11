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

use pocketmine\network\NetworkSession;

class AgentAnimationPacket extends DataPacket{
    public const NETWORK_ID = ProtocolInfo::AGENT_ANIMATION_PACKET;

    public const TYPE_ARM_SWING = 0;
    public const TYPE_SHRUG = 1;

    public int $animationType;
    public int $actorRuntimeId;

    /**
     * @generate-create-func
     */
    public static function create(int $animationType, int $actorRuntimeId) : self{
        $result = new self;
        $result->animationType = $animationType;
        $result->actorRuntimeId = $actorRuntimeId;
        return $result;
    }

    public function getAnimationType() : int{ return $this->animationType; }

    public function getActorRuntimeId() : int{ return $this->actorRuntimeId; }

    public function decodePayload() : void{
        $this->animationType = $this->getByte();
        $this->actorRuntimeId = $this->getActorRuntimeId();
    }

    public function encodePayload() : void{
        $this->putByte($this->animationType);
        $this->putActorRuntimeId($this->actorRuntimeId);
    }

    public function handle(NetworkSession $session) : bool{
        return $session->handleAgentAnimation($this);
    }
}