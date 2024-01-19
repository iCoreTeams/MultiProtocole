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

class DebugInfoPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::DEBUG_INFO_PACKET;

	/** @var int */
	public $playerUniqueId;
	/** @var string */
	public $data;

	public function decodePayload(){
		$this->playerUniqueId = $this->getActorUniqueId();
		$this->data = $this->getString();
	}

	public function encodePayload(){
		$this->putActorUniqueId($this->playerUniqueId);
		$this->putString($this->data);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleDebugInfo($this);
	}
}