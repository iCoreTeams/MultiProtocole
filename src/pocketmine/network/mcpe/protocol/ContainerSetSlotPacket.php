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

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\item\Item;
use pocketmine\network\NetworkSession;

class ContainerSetSlotPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::CONTAINER_SET_SLOT_PACKET;

	public $windowId;
	public $slot;
	public $hotbarSlot = 0;
	/** @var Item */
	public $item;
	public $selectSlot = 0;

	public function decodePayload(){
		$this->windowId = $this->getByte();
		$this->slot = $this->getVarInt();
		$this->hotbarSlot = $this->getVarInt();
		$this->item = $this->getSlot();
		$this->selectSlot = $this->getByte();
	}

	public function encodePayload(){
		$this->putByte($this->windowId);
		$this->putVarInt($this->slot);
		$this->putVarInt($this->hotbarSlot);
		$this->putSlot($this->item);
		$this->putByte($this->selectSlot);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleContainerSetSlot($this);
	}

}
