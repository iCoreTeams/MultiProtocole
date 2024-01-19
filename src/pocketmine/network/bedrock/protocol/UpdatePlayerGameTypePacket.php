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

use pocketmine\network\NetworkSession;

class UpdatePlayerGameTypePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_PLAYER_GAME_TYPE_PACKET;

	/** @var int */
	public $gameType;
	/** @var int */
	public $playerUniqueId;

	public function decodePayload(){
		$this->gameType = $this->getVarInt();
		$this->playerUniqueId = $this->getActorUniqueId();
	}

	public function encodePayload(){
		$this->putVarInt($this->gameType);
		$this->putActorUniqueId($this->playerUniqueId);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleUpdatePlayerGameType($this);
	}
}