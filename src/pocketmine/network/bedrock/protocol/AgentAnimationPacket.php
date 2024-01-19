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

namespace pocketmine\network\bedrock\protocol;

use pocketmine\network\NetworkSession;

class AgentAnimationPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::AGENT_ANIMATION_PACKET;

	public const TYPE_ARM_SWING = 0;
	public const TYPE_SHRUG = 1;

	private int $animationType;
	private int $actorRuntimeId;

	public function getAnimationType() : int{ return $this->animationType; }

	public function getActorRuntimeId() : int{ return $this->actorRuntimeId; }

	public function decodePayload(){
		$this->animationType = $this->getByte();
		$this->actorRuntimeId = $this->getActorRuntimeId();
	}

	public function encodePayload(){
		$this->putByte($this->animationType);
		$this->putActorRuntimeId($this->actorRuntimeId);
	}

    
	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleAgentAnimation($this);
	}
}