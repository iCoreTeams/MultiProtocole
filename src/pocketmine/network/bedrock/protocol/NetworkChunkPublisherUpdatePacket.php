<?php

declare(strict_types=1);

namespace pocketmine\network\bedrock\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\bedrock\protocol\types\ChunkPosition;
use pocketmine\network\NetworkSession;

class NetworkChunkPublisherUpdatePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::NETWORK_CHUNK_PUBLISHER_UPDATE_PACKET;

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;
	/** @var int */
	public $radius;
    /** @var ChunkPosition[] */
    public array $savedChunks = [];

	public function decodePayload(){
		$this->getSignedBlockPosition($this->x, $this->y, $this->z);
		$this->radius = $this->getUnsignedVarInt();

        for($i = 0, $this->savedChunks = [], $count = $this->getLInt(); $i < $count; $i++){
            $this->savedChunks[] = ChunkPosition::read($this);
        }
	}

	public function encodePayload(){
		$this->putSignedBlockPosition($this->x, $this->y, $this->z);
		$this->putUnsignedVarInt($this->radius);

        $this->putLInt(count($this->savedChunks));
        foreach($this->savedChunks as $chunk){
            $chunk->write($this);
        }
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleNetworkChunkPublisherUpdate($this);
	}
}
