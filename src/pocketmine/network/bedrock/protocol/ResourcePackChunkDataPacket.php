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

class ResourcePackChunkDataPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACK_CHUNK_DATA_PACKET;

	/** @var string */
	public $packId;
	/** @var int */
	public $chunkIndex;
	/** @var int */
	public $offset;
	/** @var string */
	public $data;

	public function decodePayload(){
		$this->packId = $this->getString();
		$this->chunkIndex = $this->getLInt();
		$this->offset = $this->getLLong();
		$this->data = $this->getString();
	}

	public function encodePayload(){
		$this->putString($this->packId);
		$this->putLInt($this->chunkIndex);
		$this->putLLong($this->offset);
		$this->putString($this->data);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleResourcePackChunkData($this);
	}
}
