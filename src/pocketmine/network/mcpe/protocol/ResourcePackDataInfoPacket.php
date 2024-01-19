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

class ResourcePackDataInfoPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACK_DATA_INFO_PACKET;

	public $packId;
	public $maxChunkSize;
	public $chunkCount;
	public $compressedPackSize;
	public $sha256;

	public function decodePayload(){
		$this->packId = $this->getString();
		$this->maxChunkSize = $this->getLInt();
		$this->chunkCount = $this->getLInt();
		$this->compressedPackSize = $this->getLLong();
		$this->sha256 = $this->getString();
	}

	public function encodePayload(){
		$this->putString($this->packId);
		$this->putLInt($this->maxChunkSize);
		$this->putLInt($this->chunkCount);
		$this->putLLong($this->compressedPackSize);
		$this->putString($this->sha256);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleResourcePackDataInfo($this);
	}

}