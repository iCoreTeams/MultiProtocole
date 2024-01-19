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


use InvalidArgumentException;
use pocketmine\network\NetworkSession;
use function count;

class PlayerFogPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_FOG_PACKET;

	/** @var string[] */
	public $fogLayers;

	public function decodePayload(){
		$count = $this->getUnsignedVarInt();
		if($count > 128){
			throw new InvalidArgumentException("Too many fog layers: $count");
		}
		for($i = 0; $i < $count; ++$i){
			$this->fogLayers[] = $this->getString();
		}
	}

	public function encodePayload(){
		$this->putUnsignedVarInt(count($this->fogLayers));
		foreach($this->fogLayers as $fogLayer){
			$this->putString($fogLayer);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePlayerFog($this);
	}
}
