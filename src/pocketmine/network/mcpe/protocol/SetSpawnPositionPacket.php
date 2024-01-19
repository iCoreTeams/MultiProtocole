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

class SetSpawnPositionPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SET_SPAWN_POSITION_PACKET;

	public const TYPE_PLAYER_SPAWN = 0;
	public const TYPE_WORLD_SPAWN = 1;

	public $spawnType;
	public $x;
	public $y;
	public $z;
	public $spawnForced;

	public function decodePayload(){
		$this->spawnType = $this->getVarInt();
		$this->getBlockPosition($this->x, $this->y, $this->z);
		$this->spawnForced = $this->getBool();
	}

	public function encodePayload(){
		$this->putVarInt($this->spawnType);
		$this->putBlockPosition($this->x, $this->y, $this->z);
		$this->putBool($this->spawnForced);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSetSpawnPosition($this);
	}

}
