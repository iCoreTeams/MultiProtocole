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
use pocketmine\utils\UUID;
use function count;

class EmoteListPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::EMOTE_LIST_PACKET;

	/** @var int */
	public $playerRuntimeId;
	/** @var UUID[] */
	public $emotePieces = [];

	public function decodePayload(){
		$this->playerRuntimeId = $this->getActorRuntimeId();
		for($i = 0, $count = $this->getUnsignedVarInt(); $i < $count; ++$i){
			$this->emotePieces[] = $this->getUUID();
		}
	}

	public function encodePayload(){
		$this->putActorRuntimeId($this->playerRuntimeId);
		$this->putUnsignedVarInt(count($this->emotePieces));
		foreach($this->emotePieces as $uuid){
			$this->putUUID($uuid);
		}
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleEmoteList($this);
	}
}