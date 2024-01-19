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

class ModalFormResponsePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MODAL_FORM_RESPONSE_PACKET;

	public const CANCEL_REASON_CLOSED = 0;
	/** Sent if a form is sent when the player is on a loading screen */
	public const CANCEL_REASON_USER_BUSY = 1;

	/** @var int */
	public $formId;
	/** @var string|null */
	public $formData; //json
	/** @var int|null */
	public $cancelReason;

	public function decodePayload(){
		$this->formId = $this->getUnsignedVarInt();
		$this->formData = $this->getBool() ? $this->getString() : null;
		$this->cancelReason = $this->getBool() ? $this->getByte() : null;
	}

	public function encodePayload(){
		$this->putUnsignedVarInt($this->formId);
		if($this->formData !== null){
			$this->putBool(true);
			$this->putString($this->formData);
		}else{
			$this->putBool(false);
		}
		if($this->cancelReason !== null){
			$this->putBool(true);
			$this->putByteRotation($this->cancelReason);
		}else{
			$this->putBool(false);
		}
	}

	public function mustBeDecoded() : bool{
		return true;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleModalFormResponse($this);
	}
}
