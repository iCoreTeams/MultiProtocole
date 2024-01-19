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

class ServerToClientHandshakePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SERVER_TO_CLIENT_HANDSHAKE_PACKET;

	/**
	 * @var string
	 * Server pubkey and token is contained in the JWT.
	 */
	public $jwt;

	public function canBeSentBeforeLogin() : bool{
		return true;
	}

	public function decodePayload(){
		$this->jwt = $this->getString();
	}

	public function encodePayload(){
		$this->putString($this->jwt);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleServerToClientHandshake($this);
	}
}
