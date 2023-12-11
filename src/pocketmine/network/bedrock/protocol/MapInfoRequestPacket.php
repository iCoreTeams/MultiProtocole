<?php

declare(strict_types=1);


namespace pocketmine\network\bedrock\protocol;

#include <rules/DataPacket.h>


use pocketmine\network\bedrock\protocol\types\MapInfoRequestPacketClientPixel;
use pocketmine\network\NetworkSession;

class MapInfoRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MAP_INFO_REQUEST_PACKET;

	/** @var int */
	public $mapId;
    /** @var MapInfoRequestPacketClientPixel[] */
    public array $clientPixels = [];

	public function decodePayload(){
		$this->mapId = $this->getActorUniqueId();

        $this->clientPixels = [];
        for($i = 0, $count = $this->getLInt(); $i < $count; $i++){
            $this->clientPixels[] = MapInfoRequestPacketClientPixel::read($this);
        }
	}

	public function encodePayload(){
		$this->putActorUniqueId($this->mapId);

        $this->putLInt(count($this->clientPixels));
        foreach($this->clientPixels as $pixel){
            $pixel->write($this);
        }
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleMapInfoRequest($this);
	}
}
