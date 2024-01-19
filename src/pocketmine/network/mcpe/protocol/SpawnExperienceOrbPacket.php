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

class SpawnExperienceOrbPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SPAWN_EXPERIENCE_ORB_PACKET;

	public $x;
	public $y;
	public $z;
	public $amount;

	public function decodePayload(){
		$this->getVector3f($this->x, $this->y, $this->z);
		$this->amount = $this->getVarInt();
	}

	public function encodePayload(){
		$this->putVector3f($this->x, $this->y, $this->z);
		$this->putVarInt($this->amount);
	}
	
	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSpawnExperienceOrb($this);
	}
}