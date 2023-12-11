<?php

declare(strict_types=1);

namespace pocketmine\network\bedrock\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\NetworkSession;

class ModalFormResponsePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MODAL_FORM_RESPONSE_PACKET;

	/** @var int */
	public $formId;
    public $formData; //json
    public $cancelReason;

	public function decodePayload(){
		$this->formId = $this->getUnsignedVarInt();
        $this->formData = $this->readOptional(\Closure::fromCallable([$this, 'getString']));
        $this->cancelReason = $this->readOptional(\Closure::fromCallable([$this, 'getByte']));
	}

	public function encodePayload(){
		$this->putUnsignedVarInt($this->formId);
        $this->writeOptional($this->formData, \Closure::fromCallable([$this, 'putString']));
        $this->writeOptional($this->cancelReason, \Closure::fromCallable([$this, 'putByte']));
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleModalFormResponse($this);
	}
}
