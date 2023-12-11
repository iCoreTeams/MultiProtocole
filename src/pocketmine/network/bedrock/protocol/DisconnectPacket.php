<?php

declare(strict_types=1);

namespace pocketmine\network\bedrock\protocol;

#include <rules/DataPacket.h>


use pocketmine\network\NetworkSession;

class DisconnectPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::DISCONNECT_PACKET;

    public int $reason = 0; //TODO: add constants / enum
	public string  $message = "";

	public function canBeSentBeforeLogin() : bool{
		return true;
	}

	public function decodePayload(){
        $this->reason = $this->getVarInt();
        $hideDisconnectionScreen = $this->getBool();
        if(!$hideDisconnectionScreen){
            $this->message = $this->getString();
        }
	}

	public function encodePayload(){
        $this->putVarInt($this->reason);
        $this->putBool($this->message === null);
        if($this->message !== null){
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
