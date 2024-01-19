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

use pocketmine\network\bedrock\protocol\types\ChunkCacheBlob;
use pocketmine\network\NetworkSession;

class ClientCacheMissResponsePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::CLIENT_CACHE_MISS_RESPONSE_PACKET;

	/** @var ChunkCacheBlob[] */
	public $blobs = [];

	public function decodePayload(){
		for($i = 0, $count = $this->getUnsignedVarInt(); $i < $count; ++$i){
			$hash = $this->getLLong();
			$payload = $this->getString();
			$this->blobs[] = new ChunkCacheBlob($hash, $payload);
		}
	}

	public function encodePayload(){
		$this->putUnsignedVarInt(count($this->blobs));
		foreach($this->blobs as $blob){
			$this->putLLong($blob->hash);
			$this->putString($blob->payload);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleClientCacheMissResponse($this);
	}
}
