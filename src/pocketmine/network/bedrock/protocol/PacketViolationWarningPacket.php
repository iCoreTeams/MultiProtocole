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

class PacketViolationWarningPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PACKET_VIOLATION_WARNING_PACKET;

	public const TYPE_MALFORMED = 0;

	public const SEVERITY_WARNING = 0;
	public const SEVERITY_FINAL_WARNING = 1;
	public const SEVERITY_TERMINATING_CONNECTION = 2;

	/** @var int */
	public $type;
	/** @var int */
	public $severity;
	/** @var int */
	public $packetId;
	/** @var string */
	public $violationContext;

	public function decodePayload(){
		$this->type = $this->getVarInt();
		$this->severity = $this->getVarInt();
		$this->packetId = $this->getVarInt();
		$this->violationContext = $this->getString();
	}

	public function encodePayload(){
		$this->putVarInt($this->type);
		$this->putVarInt($this->severity);
		$this->putVarInt($this->packetId);
		$this->putString($this->violationContext);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePacketViolationWarning($this);
	}
}