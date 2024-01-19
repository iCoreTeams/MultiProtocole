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


use pocketmine\network\NetworkSession;

class MobEquipmentPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MOB_EQUIPMENT_PACKET;

	public $entityRuntimeId;
	public $item;
	public $inventorySlot;
	public $hotbarSlot;
	public $windowId = 0;

	public function decodePayload(){
		$this->entityRuntimeId = $this->getEntityRuntimeId();
		$this->item = $this->getSlot();
		$this->inventorySlot = $this->getByte();
		$this->hotbarSlot = $this->getByte();
		$this->windowId = $this->getByte();
	}

	public function encodePayload(){
		$this->putEntityRuntimeId($this->entityRuntimeId);
		$this->putSlot($this->item);
		$this->putByte($this->inventorySlot);
		$this->putByte($this->hotbarSlot);
		$this->putByte($this->windowId);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleMobEquipment($this);
	}

}
