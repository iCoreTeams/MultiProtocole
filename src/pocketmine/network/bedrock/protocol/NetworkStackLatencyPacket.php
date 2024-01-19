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

class NetworkStackLatencyPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::NETWORK_STACK_LATENCY_PACKET;

	/** @var int */
	public $timestamp;
	/** @var bool */
	public $needResponse = false;

	public function decodePayload(){
		$this->timestamp = $this->getLLong();
		$this->needResponse = $this->getBool();
	}

	public function encodePayload(){
		$this->putLLong($this->timestamp);
		$this->putBool($this->needResponse);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleNetworkStackLatency($this);
	}
}
