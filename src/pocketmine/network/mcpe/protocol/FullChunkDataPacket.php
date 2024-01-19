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

class FullChunkDataPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::FULL_CHUNK_DATA_PACKET;

	public $chunkX;
	public $chunkZ;
	public $data;

	public function decodePayload(){
		$this->chunkX = $this->getVarInt();
		$this->chunkZ = $this->getVarInt();
		$this->data = $this->getString();
	}

	public function encodePayload(){
		$this->putVarInt($this->chunkX);
		$this->putVarInt($this->chunkZ);
		$this->putString($this->data);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleFullChunkData($this);
	}

}
