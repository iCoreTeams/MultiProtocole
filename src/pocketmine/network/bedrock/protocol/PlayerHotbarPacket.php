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
use pocketmine\network\bedrock\protocol\types\inventory\ContainerIds;

/**
 * One of the most useless packets.
 */
class PlayerHotbarPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_HOTBAR_PACKET;

	/** @var int */
	public $selectedHotbarSlot;
	/** @var int */
	public $windowId = ContainerIds::INVENTORY;
	/** @var bool */
	public $selectHotbarSlot = true;

	public function decodePayload(){
		$this->selectedHotbarSlot = $this->getUnsignedVarInt();
		$this->windowId = $this->getByte();
		$this->selectHotbarSlot = $this->getBool();
	}

	public function encodePayload(){
		$this->putUnsignedVarInt($this->selectedHotbarSlot);
		$this->putByte($this->windowId);
		$this->putBool($this->selectHotbarSlot);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePlayerHotbar($this);
	}
}
