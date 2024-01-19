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

class EmotePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::EMOTE_PACKET;

	public const FLAG_SERVER_SIDE = 1 << 0;
	public const FLAG_MUTE_ANNOUNCEMENT = 1 << 1;

	/** @var int */
	public $actorRuntimeId;
	/** @var string */
	public $emoteId;
	/** @var string */
	public $xboxUserId;
	/** @var string */
	public $platformChatId;
	/** @var int */
	public $flags = 0;

	public function decodePayload(){
		$this->actorRuntimeId = $this->getActorRuntimeId();
		$this->emoteId = $this->getString();
		$this->xboxUserId = $this->getString();
		$this->platformChatId = $this->getString();
		$this->flags = $this->getByte();
	}

	public function encodePayload(){
		$this->putActorRuntimeId($this->actorRuntimeId);
		$this->putString($this->emoteId);
		$this->putString($this->xboxUserId);
		$this->putString($this->platformChatId);
		$this->putByte($this->flags);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleEmote($this);
	}
}