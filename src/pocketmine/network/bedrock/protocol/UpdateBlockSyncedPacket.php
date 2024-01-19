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

class UpdateBlockSyncedPacket extends UpdateBlockPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_BLOCK_SYNCED_PACKET;

	/** @var int */
	public $actorUniqueId = 0;
	/** @var int */
	public $uvarint64_2 = 0;

	public function decodePayload(){
		parent::decodePayload();
		$this->actorUniqueId = $this->getUnsignedVarLong();
		$this->uvarint64_2 = $this->getUnsignedVarLong();
	}

	public function encodePayload(){
		parent::encodePayload();
		$this->putUnsignedVarLong($this->actorUniqueId);
		$this->putUnsignedVarLong($this->uvarint64_2);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleUpdateBlockSynced($this);
	}
}
