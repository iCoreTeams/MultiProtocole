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

class AnimatePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ANIMATE_PACKET;

	public const ACTION_SWING_ARM = 1;

	public const ACTION_STOP_SLEEP = 3;
	public const ACTION_CRITICAL_HIT = 4;

	public $action;
	public $entityRuntimeId;
	public $rowingTime = 0.0; //TODO (Boat rowing time?)

	public function decodePayload(){
		$this->action = $this->getVarInt();
		$this->entityRuntimeId = $this->getEntityRuntimeId();
		if($this->action & 0x80){
			$this->rowingTime = $this->getLFloat();
		}
	}

	public function encodePayload(){
		$this->putVarInt($this->action);
		$this->putEntityRuntimeId($this->entityRuntimeId);
		if($this->action & 0x80){
			$this->putLFloat($this->rowingTime);
		}
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleAnimate($this);
	}

}
