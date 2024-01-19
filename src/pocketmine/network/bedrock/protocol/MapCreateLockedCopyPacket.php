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

class MapCreateLockedCopyPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MAP_CREATE_LOCKED_COPY_PACKET;

	/** @var int */
	public $originalMapId;
	/** @var int */
	public $newMapId;

	public function decodePayload(){
		$this->originalMapId = $this->getVarLong();
		$this->newMapId = $this->getVarLong();
	}

	public function encodePayload(){
		$this->putVarLong($this->originalMapId);
		$this->putVarLong($this->newMapId);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleMapCreateLockedCopy($this);
	}
}
