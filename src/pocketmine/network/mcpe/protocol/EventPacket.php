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

class EventPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::EVENT_PACKET;

	public const TYPE_ACHIEVEMENT_AWARDED = 0;
	public const TYPE_ENTITY_INTERACT = 1;
	public const TYPE_PORTAL_BUILT = 2;
	public const TYPE_PORTAL_USED = 3;
	public const TYPE_MOB_KILLED = 4;
	public const TYPE_CAULDRON_USED = 5;
	public const TYPE_PLAYER_DEATH = 6;
	public const TYPE_BOSS_KILLED = 7;
	public const TYPE_AGENT_COMMAND = 8;
	public const TYPE_AGENT_CREATED = 9;

	public $playerRuntimeId;
	public $eventData;
	public $type;

	public function decodePayload(){
		$this->playerRuntimeId = $this->getEntityRuntimeId();
		$this->eventData = $this->getVarInt();
		$this->type = $this->getByte();

		//TODO: nice confusing mess
	}

	public function encodePayload(){
		$this->putEntityRuntimeId($this->playerRuntimeId);
		$this->putVarInt($this->eventData);
		$this->putByte($this->type);

		//TODO: also nice confusing mess
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleEvent($this);
	}
}