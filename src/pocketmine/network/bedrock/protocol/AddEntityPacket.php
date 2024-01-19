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

/**
 * ATTENTION! This is not an usual entity packet!
 * @see AddActorPacket
 */
class AddEntityPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_ENTITY_PACKET;

	/** @var int */
	public $entityNetId;

	public function decodePayload(){
		$this->entityNetId = $this->getEntityNetId();
	}

	public function encodePayload(){
		$this->putEntityNetId($this->entityNetId);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleAddEntity($this);
	}
}
