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

class DisconnectPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::DISCONNECT_PACKET;

	/** @var bool */
	public $hideDisconnectionScreen = false;
	/** @var string */
	public $message = "";
	public int $reason = 0;

	public function canBeSentBeforeLogin() : bool{
		return true;
	}

	public function decodePayload(){
		$this->reason = $this->getVarInt();
		$this->hideDisconnectionScreen = $this->getBool();
		if(!$this->hideDisconnectionScreen){
			$this->message = $this->getString();
		}
	}

	public function encodePayload(){
		$this->putVarInt($this->reason);
		$this->putBool($this->hideDisconnectionScreen);
		if(!$this->hideDisconnectionScreen){
			$this->putString($this->message);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleDisconnect($this);
	}
}
