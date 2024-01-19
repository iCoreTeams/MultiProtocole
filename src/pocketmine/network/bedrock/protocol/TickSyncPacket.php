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

class TickSyncPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::TICK_SYNC_PACKET;

	/** @var int */
	public $requestTimeStamp;
	/** @var int */
	public $responseTimeStamp;

	public function decodePayload(){
		$this->requestTimeStamp = $this->getLLong();
		$this->responseTimeStamp = $this->getLLong();
	}

	public function encodePayload(){
		$this->putLLong($this->requestTimeStamp);
		$this->putLLong($this->requestTimeStamp);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleTickSync($this);
	}
}