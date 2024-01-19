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


use pocketmine\entity\Attribute;
use pocketmine\network\NetworkSession;
use function array_values;

class UpdateAttributesPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_ATTRIBUTES_PACKET;

	/** @var int */
	public $actorRuntimeId;
	/** @var Attribute[] */
	public $entries = [];
	/** @var int */
	public $tick = 0;

	public function decodePayload(){
		$this->actorRuntimeId = $this->getActorRuntimeId();
		$this->entries = $this->getAttributeList();
		$this->tick = $this->getUnsignedVarLong();
	}

	public function encodePayload(){
		$this->putActorRuntimeId($this->actorRuntimeId);
		$this->putAttributeList(...array_values($this->entries));
		$this->putUnsignedVarLong($this->tick);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleUpdateAttributes($this);
	}
}
