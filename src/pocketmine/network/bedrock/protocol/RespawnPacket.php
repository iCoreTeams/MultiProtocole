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


use pocketmine\math\Vector3;
use pocketmine\network\NetworkSession;

class RespawnPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::RESPAWN_PACKET;

	public const STATE_SEARCHING_FOR_SPAWN = 0;
	public const STATE_READY_TO_SPAWN = 1;
	public const STATE_CLIENT_READY_TO_SPAWN = 2;

	/** @var Vector3 */
	public $position;
	/** @var int */
	public $respawnState;
	/** @var int */
	public $actorRuntimeId;

	public function decodePayload(){
		$this->position = $this->getVector3();
		$this->respawnState = $this->getByte();
		$this->actorRuntimeId = $this->getActorRuntimeId();
	}

	public function encodePayload(){
		$this->putVector3($this->position);
		$this->putByte($this->respawnState);
		$this->putActorRuntimeId($this->actorRuntimeId);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleRespawn($this);
	}
}
