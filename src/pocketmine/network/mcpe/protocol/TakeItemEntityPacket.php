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

class TakeItemEntityPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::TAKE_ITEM_ENTITY_PACKET;

	public $target;
	public $eid;

	public function decodePayload(){
		$this->target = $this->getEntityRuntimeId();
		$this->eid = $this->getEntityRuntimeId();
	}

	public function encodePayload(){
		$this->putEntityRuntimeId($this->target);
		$this->putEntityRuntimeId($this->eid);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleTakeItemEntity($this);
	}
}
