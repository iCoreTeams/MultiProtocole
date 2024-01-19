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

class ContainerClosePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::CONTAINER_CLOSE_PACKET;

	/** @var int */
	public $windowId;
	/** @var bool */
	public $server = false;

	public function decodePayload(){
		$this->windowId = $this->getByte();
		$this->server = $this->getBool();
	}

	public function encodePayload(){
		$this->putByte($this->windowId);
		$this->putBool($this->server);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleContainerClose($this);
	}
}
