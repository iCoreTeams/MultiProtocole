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
use pocketmine\network\bedrock\protocol\types\actor\ActorLink;

class SetActorLinkPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SET_ACTOR_LINK_PACKET;

	/** @var ActorLink */
	public $link;

	public function decodePayload(){
		$this->link = $this->getActorLink();
	}

	public function encodePayload(){
		$this->putActorLink($this->link);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSetActorLink($this);
	}
}
