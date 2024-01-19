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

class RequestNetworkSettingsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::REQUEST_NETWORK_SETTINGS_PACKET;

	/** @var int */
	public $protocolVersion;

	public function decodePayload(){
		$this->protocolVersion = $this->getInt();
	}

	public function encodePayload(){
		$this->putInt($this->protocolVersion);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleRequestNetworkSettings($this);
	}
}