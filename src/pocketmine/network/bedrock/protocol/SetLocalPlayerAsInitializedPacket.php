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

#include <rules/DataPacket.h>

use pocketmine\network\NetworkSession;

class SetLocalPlayerAsInitializedPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SET_LOCAL_PLAYER_AS_INITIALIZED_PACKET;

	/** @var int */
	public $actorRuntimeId;

	public function decodePayload(){
		$this->actorRuntimeId = $this->getActorRuntimeId();
	}

	public function encodePayload(){
		$this->putActorRuntimeId($this->actorRuntimeId);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSetLocalPlayerAsInitialized($this);
	}
}
