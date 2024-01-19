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

class RequestChunkRadiusPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::REQUEST_CHUNK_RADIUS_PACKET;

	/** @var int */
	public $radius;
	/** @var int */
	public $maxRadius;

	public function decodePayload(){
		$this->radius = $this->getVarInt();
		$this->maxRadius = $this->getByte();
	}

	public function encodePayload(){
		$this->putVarInt($this->radius);
		$this->putByte($this->maxRadius);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleRequestChunkRadius($this);
	}
}
