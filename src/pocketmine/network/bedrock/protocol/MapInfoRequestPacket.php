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


use pocketmine\network\bedrock\protocol\types\MapInfoRequestPacketClientPixel;
use pocketmine\network\NetworkSession;

class MapInfoRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MAP_INFO_REQUEST_PACKET;

	/** @var int */
	public $mapId;
	/** @var MapInfoRequestPacketClientPixel[] */
	public $clientPixels = [];

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

	public function handle(NetworkSession $session) : bool{
		return $session->handleMapInfoRequest($this);
	}
}
