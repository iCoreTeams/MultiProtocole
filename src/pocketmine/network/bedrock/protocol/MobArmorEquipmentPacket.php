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


use pocketmine\item\Item;
use pocketmine\network\bedrock\protocol\types\inventory\ItemInstance;
use pocketmine\network\NetworkSession;

class MobArmorEquipmentPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MOB_ARMOR_EQUIPMENT_PACKET;

	/** @var int */
	public $actorRuntimeId;
	/** @var ItemInstance[] */
	public $slots = [];

	public function decodePayload(){
		$this->actorRuntimeId = $this->getActorRuntimeId();
		for($i = 0; $i < 4; ++$i){
			$this->slots[$i] = $this->getItemInstance();
		}
	}

	public function encodePayload(){
		$this->putActorRuntimeId($this->actorRuntimeId);
		for($i = 0; $i < 4; ++$i){
			$this->putItemInstance($this->slots[$i]);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleMobArmorEquipment($this);
	}
}
