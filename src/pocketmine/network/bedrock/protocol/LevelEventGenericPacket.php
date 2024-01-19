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

class LevelEventGenericPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::LEVEL_EVENT_GENERIC_PACKET;

	/** @var int */
	public $eventId;
	/** @var string */
	public $namedtag;

	public function decodePayload(){
		$this->eventId = $this->getVarInt();
		$this->namedtag = $this->getRemaining();
	}

	public function encodePayload(){
		$this->putVarInt($this->eventId);
		$this->put($this->namedtag);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleLevelEventGeneric($this);
	}
}
