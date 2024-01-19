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

class PositionTrackingDBServerBroadcastPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::POSITION_TRACKING_DB_SERVER_BROADCAST_PACKET;

	public const ACTION_UPDATE = 0;
	public const ACTION_DESTROY = 1;
	public const ACTION_NOT_FOUND = 2;

	/** @var int */
	public $action;
	/** @var int */
	public $trackingId;
	/** @var string */
	public $serializedData;

	public function decodePayload(){
		$this->action = $this->getByte();
		$this->trackingId = $this->getVarInt();
		$this->serializedData = $this->getRemaining();
	}

	public function encodePayload(){
		$this->putByte($this->action);
		$this->putVarInt($this->trackingId);
		$this->put($this->serializedData);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePositionTrackingDBServerBroadcast($this);
	}
}