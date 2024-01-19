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

class PositionTrackingDBClientRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::POSITION_TRACKING_DB_CLIENT_REQUEST_PACKET;

	public const ACTION_QUERY = 0;

	/** @var int */
	public $action;
	/** @var int */
	public $trackingId;

	public function decodePayload(){
		$this->action = $this->getByte();
		$this->trackingId = $this->getVarInt();
	}

	public function encodePayload(){
		$this->putByte($this->action);
		$this->putVarInt($this->trackingId);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePositionTrackingDBClientRequest($this);
	}
}